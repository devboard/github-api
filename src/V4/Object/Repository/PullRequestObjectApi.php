<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\Query\Repository\AllPullRequestsQuery;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\AllPullRequestsResult;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;

class PullRequestObjectApi
{
    /** @var PullRequestApi */
    private $pullRequestApi;

    /** @var PullRequestFactory */
    private $pullRequestFactory;

    public function __construct(PullRequestApi $pullRequestApi, PullRequestFactory $pullRequestFactory)
    {
        $this->pullRequestApi     = $pullRequestApi;
        $this->pullRequestFactory = $pullRequestFactory;
    }

    public function getPullRequests(AllPullRequestsQuery $query): AllPullRequestsResult
    {
        $dataLists = $this->pullRequestApi->getPullRequests($query);

        $results = [];

        foreach ($dataLists as $data) {
            foreach ($data['data']['repository']['pullRequests']['edges'] as $item) {
                $results[] = $this->pullRequestFactory->create($item['node']);
            }
        }

        return new AllPullRequestsResult($query->getRepoFullName(), $results);
    }
}
