<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\AllLabelsQuery;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

class LabelApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function getLabels(AllLabelsQuery $query): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/labels.graphql');

        $variables = ['owner' => $query->getOwnerName(), 'name' => $query->getRepoName()];
        $client    = $this->clientFactory->createAppAndUserAuthenticatedClient2($query->getCredentials());

        $data = $client->graphql()->execute($queryDefinition, $variables);

        return $data;
    }
}
