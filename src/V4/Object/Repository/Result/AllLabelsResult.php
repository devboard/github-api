<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Repo\RepoFullName;
use Webmozart\Assert\Assert;

class AllLabelsResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array */
    private $labels;

    public function __construct(RepoFullName $repoFullName, array $labels)
    {
        Assert::allIsInstanceOf($labels, GitHubLabel::class);
        $this->repoFullName = $repoFullName;
        $this->labels       = $labels;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }
}
