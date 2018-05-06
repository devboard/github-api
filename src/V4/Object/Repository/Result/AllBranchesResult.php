<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Repo\RepoFullName;
use Webmozart\Assert\Assert;

class AllBranchesResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array */
    private $branches;

    public function __construct(RepoFullName $repoFullName, array $branches)
    {
        Assert::allIsInstanceOf($branches, GitHubBranch::class);

        $this->repoFullName = $repoFullName;
        $this->branches     = $branches;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getBranches(): array
    {
        return $this->branches;
    }
}
