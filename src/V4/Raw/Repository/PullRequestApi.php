<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
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

    public function getPullRequests(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $query = file_get_contents(__DIR__.'/pull_requests.graphql');

        $variables = [
            'owner'  => $repoFullName->getOwner()->getValue(),
            'name'   => $repoFullName->getRepoName()->getValue(),
            'cursor' => null,
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($installationId, $githubUserId);

        $results = [];

        do {
            $data = $client->graphql()->execute($query, $variables);

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
