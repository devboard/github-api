<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\Query\Repository\AllPullRequestsQuery;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestDetailedResponseFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\AllPullRequestsResult;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;

class PullRequestObjectApi
{
    /** @var PullRequestApi */
    private $pullRequestApi;

    /**
     * @var PullRequestDetailedResponseFactory
     */
    private $responseFactory;

    public function __construct(PullRequestApi $pullRequestApi, PullRequestDetailedResponseFactory $responseFactory)
    {
        $this->pullRequestApi  = $pullRequestApi;
        $this->responseFactory = $responseFactory;
    }

    public function getPullRequests(AllPullRequestsQuery $query): AllPullRequestsResult
    {
        $dataLists = $this->pullRequestApi->getPullRequests($query);

        $results = [];

        foreach ($dataLists as $data) {
            foreach ($data['data']['repository']['pullRequests']['edges'] as $item) {
                $results[] = $this->responseFactory->create($item['node']);
            }
        }

        return new AllPullRequestsResult($query->getRepoFullName(), $results);
    }
}
