<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\BranchFactory;

class BranchApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    /**
     * @var BranchFactory
     */
    private $branchFactory;

    public function __construct(GitHubClientFactory $clientFactory, BranchFactory $branchFactory)
    {
        $this->clientFactory = $clientFactory;
        $this->branchFactory = $branchFactory;
    }

    /** @return array|GitHubBranch[] */
    public function getBranches(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $data = $this->getRawBranches($repoFullName, $installationId, $githubUserId);

        $results = [];

        foreach ($data['data']['repository']['refs']['edges'] as $item) {
            $results[] = $this->branchFactory->createFromBranchData($repoFullName, $item['node']);
        }

        return $results;
    }

    public function getRawBranches(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId)
    {
        $query = file_get_contents(__DIR__.'/branches.graphql');

        $variables = [
            'owner' => $repoFullName->getOwner()->getValue(),
            'name'  => $repoFullName->getRepoName()->getValue(),
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($installationId, $githubUserId);

        $data = $client->graphql()->execute($query, $variables);

        return $data;
    }
}
