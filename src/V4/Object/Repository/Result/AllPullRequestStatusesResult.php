<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestStatusCollection;
use Webmozart\Assert\Assert;

class AllPullRequestStatusesResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array|PullRequestStatusCollection[] */
    private $pullRequestStatusCollections;

    public function __construct(RepoFullName $repoFullName, array $pullRequestStatusCollections)
    {
        Assert::allIsInstanceOf($pullRequestStatusCollections, PullRequestStatusCollection::class);
        $this->repoFullName                 = $repoFullName;
        $this->pullRequestStatusCollections = $pullRequestStatusCollections;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getPullRequestStatusCollections(): array
    {
        return $this->pullRequestStatusCollections;
    }
}
