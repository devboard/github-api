<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\PullRequestFactory;
use Github\Api\GraphQL;

class PullRequestApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    /**
     * @var PullRequestFactory
     */
    private $pullRequestFactory;

    public function __construct(GitHubClientFactory $clientFactory, PullRequestFactory $pullRequestFactory)
    {
        $this->clientFactory      = $clientFactory;
        $this->pullRequestFactory = $pullRequestFactory;
    }

    /** @return array|GitHubPullRequest[] */
    public function getPullRequests(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $dataLists = $this->getRawPullRequests($repoFullName, $installationId, $githubUserId);

        $results = [];

        foreach ($dataLists as $data) {
            foreach ($data['data']['repository']['pullRequests']['edges'] as $item) {
                $results[] = $this->pullRequestFactory->create($item['node']);
            }
        }

        return $results;
    }

    public function getRawPullRequests(
        RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId
    ) {
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
