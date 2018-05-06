<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\BranchStatusCollection;
use Webmozart\Assert\Assert;

class AllBranchStatusesResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array|BranchStatusCollection[] */
    private $branchStatusCollections;

    public function __construct(RepoFullName $repoFullName, array $branchStatusCollections)
    {
        Assert::allIsInstanceOf($branchStatusCollections, BranchStatusCollection::class);
        $this->repoFullName            = $repoFullName;
        $this->branchStatusCollections = $branchStatusCollections;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getBranchStatusCollections(): array
    {
        return $this->branchStatusCollections;
    }
}
