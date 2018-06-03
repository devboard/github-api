<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result;

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

    public function serialize(): array
    {
        $milestones = [];

        foreach ($this->milestones as $milestone) {
            $milestones[] = $milestone->serialize();
        }

        return ['repoFullName' => $this->repoFullName->serialize(), 'milestones' => $milestones];
    }

    public static function deserialize(array $data): self
    {
        $milestones = [];

        foreach ($data['milestones'] as $milestone) {
            $milestones[] = GitHubMilestone::deserialize($milestone);
        }

        return new self(RepoFullName::deserialize($data['repoFullName']), $milestones);
    }
}
