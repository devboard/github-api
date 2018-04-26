<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\LabelFactory;

class LabelApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    /**
     * @var LabelFactory
     */
    private $branchFactory;

    public function __construct(GitHubClientFactory $clientFactory, LabelFactory $branchFactory)
    {
        $this->clientFactory = $clientFactory;
        $this->branchFactory = $branchFactory;
    }

    /** @return array|GitHubLabel[] */
    public function getLabels(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $data = $this->getRawLabels($repoFullName, $installationId, $githubUserId);

        $results = [];

        foreach ($data['data']['repository']['labels']['edges'] as $item) {
            $results[] = $this->branchFactory->create($item['node']);
        }

        return $results;
    }

    public function getRawLabels(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId)
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
