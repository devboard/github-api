<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Response;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\GitHubStatus;
use Git\Commit\CommitSha;
use Webmozart\Assert\Assert;

class BranchStatusCollection
{
    /** @var BranchName */
    private $branchName;

    /** @var CommitSha */
    private $sha;

    /** @var array */
    private $statuses;

    public function __construct(BranchName $branchName, CommitSha $sha, array $statuses)
    {
        Assert::allIsInstanceOf($statuses, GitHubStatus::class);

        $this->branchName = $branchName;
        $this->sha        = $sha;
        $this->statuses   = $statuses;
    }

    public function getBranchName(): BranchName
    {
        return $this->branchName;
    }

    public function getSha(): CommitSha
    {
        return $this->sha;
    }

    public function getStatuses(): array
    {
        return $this->statuses;
    }
}
