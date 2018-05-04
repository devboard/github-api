<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\BranchStatusCollection;
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
            $statuses   = [];

            if (null !== $edge['node']['target']['status']) {
                foreach ($edge['node']['target']['status']['contexts'] as $context) {
                    $statuses[] = $this->statusFactory->create($context);
                }
            }
            $results[] = new BranchStatusCollection($branchName, $statuses);
        }

        return $results;
    }
}
