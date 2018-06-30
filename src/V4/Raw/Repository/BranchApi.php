<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\Request\AllBranchesQuery;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

class BranchApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function allBranches(RepoFullName $fullName, InstallationCredentials $credentials): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/branches.graphql');

        $variables = [
            'owner' => $fullName->getOwner()->__toString(),
            'name'  => $fullName->getRepoName()->__toString(),
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($credentials);

        $data = $client->graphql()->execute($queryDefinition, $variables);

        return $data;
    }

    /**
     * @deprecated REMOVE THIS ONE IN VERSION 2.0
     */
    public function handleAllBranchesQuery(AllBranchesQuery $query): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/branches.graphql');

        $variables = ['owner' => (string) $query->getOwnerName(), 'name' => (string) $query->getRepoName()];
        $client    = $this->clientFactory->createAppAndUserAuthenticatedClient($query->getCredentials());

        $data = $client->graphql()->execute($queryDefinition, $variables);

        return $data;
    }
}
