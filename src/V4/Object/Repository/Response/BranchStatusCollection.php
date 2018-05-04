<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Response;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\GitHubStatus;
use Webmozart\Assert\Assert;

class BranchStatusCollection
{
    /** @var BranchName */
    private $branchName;

    /** @var array */
    private $statuses;

    public function __construct(BranchName $branchName, array $statuses)
    {
        Assert::allIsInstanceOf($statuses, GitHubStatus::class);

        $this->branchName = $branchName;
        $this->statuses   = $statuses;
    }

    public function getBranchName(): BranchName
    {
        return $this->branchName;
    }

    public function getStatuses(): array
    {
        return $this->statuses;
    }
}
