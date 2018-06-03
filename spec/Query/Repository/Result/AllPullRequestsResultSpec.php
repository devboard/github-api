<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Query\Repository\Result\AllPullRequestsResult;
use DevboardLib\GitHubApi\Query\Repository\Result\RepositoryResult;
use DevboardLib\GitHubApi\Query\Repository\Result\Response\PullRequestDetailedResponse;
use PhpSpec\ObjectBehavior;

class AllPullRequestsResultSpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, PullRequestDetailedResponse $pullRequestDetailedResponse)
    {
        $this->beConstructedWith($repoFullName, [$pullRequestDetailedResponse]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllPullRequestsResult::class);
        $this->shouldImplement(RepositoryResult::class);
    }
}
