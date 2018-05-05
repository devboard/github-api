<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Query\Repository\AllBranchesQuery;

class BranchApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function getBranches(AllBranchesQuery $input): array
    {
        $query = file_get_contents(__DIR__.'/branches.graphql');

        $variables = ['owner' => $input->getOwnerName(), 'name' => $input->getRepoName()];
        $client    = $this->clientFactory->createAppAndUserAuthenticatedClient2($input->getCredentials());

        $data = $client->graphql()->execute($query, $variables);

        return $data;
    }
}
