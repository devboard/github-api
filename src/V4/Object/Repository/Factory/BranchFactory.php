<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Repo\RepoFullName;

class BranchFactory
{
    /** @var CommitFactory */
    private $commitFactory;

    public function __construct(CommitFactory $commitFactory)
    {
        $this->commitFactory = $commitFactory;
    }

    public function createFromBranchData(RepoFullName $repoFullName, array $data): GitHubBranch
    {
        return new GitHubBranch(
            $repoFullName,
            new BranchName($data['name']),
            $this->commitFactory->createFromBranchData($data['target'])
        );
    }
}
