<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\Repo\RepoFullName;
use Webmozart\Assert\Assert;

class AllMilestonesResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array */
    private $milestones;

    public function __construct(RepoFullName $repoFullName, array $milestones)
    {
        Assert::allIsInstanceOf($milestones, GitHubMilestone::class);
        $this->repoFullName = $repoFullName;
        $this->milestones   = $milestones;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getMilestones(): array
    {
        return $this->milestones;
    }
}
