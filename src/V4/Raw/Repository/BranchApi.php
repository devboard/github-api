<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\AllBranchesQuery;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

class BranchApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function getBranches(AllBranchesQuery $query): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/branches.graphql');

        $variables = ['owner' => (string) $query->getOwnerName(), 'name' => (string) $query->getRepoName()];
        $client    = $this->clientFactory->createAppAndUserAuthenticatedClient($query->getCredentials());

        $data = $client->graphql()->execute($queryDefinition, $variables);

        return $data;
    }
}
