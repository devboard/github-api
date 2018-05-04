<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

class LabelApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function getLabels(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $query = file_get_contents(__DIR__.'/labels.graphql');

        $variables = [
            'owner' => $repoFullName->getOwner()->getValue(),
            'name'  => $repoFullName->getRepoName()->getValue(),
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($installationId, $githubUserId);

        $data = $client->graphql()->execute($query, $variables);

        return $data;
    }
}
