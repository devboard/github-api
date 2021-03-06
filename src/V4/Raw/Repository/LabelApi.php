<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

class LabelApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function allLabels(RepoFullName $fullName, InstallationCredentials $credentials, $cursor = null): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/labels.graphql');

        $variables = [
            'owner'  => $fullName->getOwner()->asString(),
            'name'   => $fullName->getRepoName()->asString(),
            'cursor' => $cursor,
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($credentials);

        $data = $client->graphql()->execute($queryDefinition, $variables);

        return $data;
    }
}
