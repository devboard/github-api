<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\BranchFactory;
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
    public function getBranches(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $data = $this->branchApi->getBranches($repoFullName, $installationId, $githubUserId);

        $results = [];

        foreach ($data['data']['repository']['refs']['edges'] as $item) {
            $results[] = $this->branchFactory->createFromBranchData($repoFullName, $item['node']);
        }

        return $results;
    }
}
