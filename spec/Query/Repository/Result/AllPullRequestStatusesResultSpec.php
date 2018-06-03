<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Query\Repository\Result\AllPullRequestStatusesResult;
use DevboardLib\GitHubApi\Query\Repository\Result\RepositoryResult;
use DevboardLib\GitHubApi\Query\Repository\Result\Response\PullRequestStatusCollection;
use PhpSpec\ObjectBehavior;

class AllPullRequestStatusesResultSpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, PullRequestStatusCollection $pullRequestStatusCollection)
    {
        $this->beConstructedWith($repoFullName, [$pullRequestStatusCollection]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllPullRequestStatusesResult::class);
        $this->shouldImplement(RepositoryResult::class);
    }
}
