<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result;

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

    public function serialize(): array
    {
        $branches = [];

        foreach ($this->branches as $branch) {
            $branches[] = $branch->serialize();
        }

        return ['repoFullName' => $this->repoFullName->serialize(), 'branches' => $branches];
    }

    public static function deserialize(array $data): self
    {
        $branches = [];

        foreach ($data['branches'] as $branch) {
            $branches[] = GitHubBranch::deserialize($branch);
        }

        return new self(RepoFullName::deserialize($data['repoFullName']), $branches);
    }
}
