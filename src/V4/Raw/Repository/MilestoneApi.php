<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllMilestonesQuery;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

class MilestoneApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function handleAllMilestonesQuery(AllMilestonesQuery $query): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/milestones.graphql');

        $variables = ['owner' => (string) $query->getOwnerName(), 'name' => (string) $query->getRepoName()];
        $client    = $this->clientFactory->createAppAndUserAuthenticatedClient($query->getCredentials());

        $data = $client->graphql()->execute($queryDefinition, $variables);

        return $data;
    }
}
