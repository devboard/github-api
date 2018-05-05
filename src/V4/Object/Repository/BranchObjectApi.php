<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\BranchFactory;
use DevboardLib\GitHubApi\V4\Query\Repository\AllBranchesQuery;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;

class BranchObjectApi
{
    /** @var BranchApi */
    private $branchApi;

    /** @var BranchFactory */
    private $branchFactory;

    public function __construct(BranchApi $branchApi, BranchFactory $branchFactory)
    {
        $this->branchApi     = $branchApi;
        $this->branchFactory = $branchFactory;
    }

    /** @return array|GitHubBranch[] */
    public function getBranches(AllBranchesQuery $query): array
    {
        $data = $this->branchApi->getBranches($query);

        $results = [];

        foreach ($data['data']['repository']['refs']['edges'] as $item) {
            $results[] = $this->branchFactory->createFromBranchData($query->getRepoFullName(), $item['node']);
        }

        return $results;
    }
}
