<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHubApi\Query\Repository\AllBranchStatusesQuery;
use DevboardLib\GitHubApi\Query\Repository\AllPullRequestStatusesQuery;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\BranchStatusCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestStatusCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\AllBranchStatusesResult;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\AllPullRequestStatusesResult;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;

class StatusObjectApi
{
    /**
     * @var StatusApi
     */
    private $branchApi;

    /**
     * @var StatusFactory
     */
    private $statusFactory;

    public function __construct(StatusApi $branchApi, StatusFactory $statusFactory)
    {
        $this->branchApi     = $branchApi;
        $this->statusFactory = $statusFactory;
    }

    public function getBranches(AllBranchStatusesQuery $query): AllBranchStatusesResult
    {
        $data = $this->branchApi->getBranches($query);

        $results = [];

        foreach ($data['data']['repository']['refs']['edges'] as $edge) {
            $branchName = new BranchName($edge['node']['name']);
            $sha        = new CommitSha($edge['node']['target']['oid']);
            $statuses   = [];

            if (null !== $edge['node']['target']['status']) {
                foreach ($edge['node']['target']['status']['contexts'] as $context) {
                    $statuses[] = $this->statusFactory->create($context);
                }
            }
            $results[] = new BranchStatusCollection($branchName, $sha, $statuses);
        }

        return new AllBranchStatusesResult($query->getRepoFullName(), $results);
    }

    public function getPullRequests(AllPullRequestStatusesQuery $query): AllPullRequestStatusesResult
    {
        $dataLists = $this->branchApi->getPullRequests($query);

        $results = [];
        foreach ($dataLists as $data) {
            foreach ($data['data']['repository']['pullRequests']['edges'] as $edge) {
                $number   = new PullRequestNumber($edge['node']['number']);
                $statuses = [];

                if (null !== $edge['node']['headRef']) {
                    if (null !== $edge['node']['headRef']['target']['status']) {
                        foreach ($edge['node']['headRef']['target']['status']['contexts'] as $context) {
                            $statuses[] = $this->statusFactory->create($context);
                        }
                    }
                }
                $results[] = new PullRequestStatusCollection($number, $statuses);
            }
        }

        return new AllPullRequestStatusesResult($query->getRepoFullName(), $results);
    }
}
