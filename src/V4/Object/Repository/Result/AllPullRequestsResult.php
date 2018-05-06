<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\Repo\RepoFullName;
use Webmozart\Assert\Assert;

class AllPullRequestsResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array */
    private $pullRequests;

    public function __construct(RepoFullName $repoFullName, array $pullRequests)
    {
        Assert::allIsInstanceOf($pullRequests, GitHubPullRequest::class);
        $this->repoFullName = $repoFullName;
        $this->pullRequests = $pullRequests;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getPullRequests(): array
    {
        return $this->pullRequests;
    }
}
