<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\BranchStatusCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestStatusCollection;
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

    /** @return array|BranchStatusCollection[] */
    public function getBranches(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $data = $this->branchApi->getBranches($repoFullName, $installationId, $githubUserId);

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

        return $results;
    }

    /** @return array|PullRequestStatusCollection[] */
    public function getPullRequests(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $dataLists = $this->branchApi->getPullRequests($repoFullName, $installationId, $githubUserId);

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

        return $results;
    }
}
