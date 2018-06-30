<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
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

    public function allPullRequests(RepoFullName $fullName, InstallationCredentials $credentials, $cursor = null): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/pull_requests.graphql');

        $variables = [
            'owner'  => $fullName->getOwner()->__toString(),
            'name'   => $fullName->getRepoName()->__toString(),
            'cursor' => $cursor,
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($credentials);

        $data = $client->graphql()->execute($queryDefinition, $variables);

        return $data;
    }

    /**
     * @deprecated REMOVE THIS ONE IN VERSION 2.0
     */
    public function handleAllPullRequestsQuery(AllPullRequestsQuery $query): array
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
