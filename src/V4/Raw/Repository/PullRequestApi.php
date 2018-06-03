<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllPullRequestsQuery;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use Github\Api\GraphQL;

class PullRequestApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function getPullRequests(AllPullRequestsQuery $query): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/pull_requests.graphql');

        $variables = [
            'owner'  => (string) $query->getOwnerName(),
            'name'   => (string) $query->getRepoName(),
            'cursor' => null,
        ];

        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($query->getCredentials());

        $results = [];

        do {
            $data = $client->graphql()->execute($queryDefinition, $variables);

            $results[] = $data;

            if (false === $data['data']['repository']['pullRequests']['pageInfo']['hasNextPage']) {
                break;
            }
            $lastId = $data['data']['repository']['pullRequests']['pageInfo']['endCursor'];

            $variables['cursor'] = $lastId;
        } while (true);

        return $results;
    }
}
