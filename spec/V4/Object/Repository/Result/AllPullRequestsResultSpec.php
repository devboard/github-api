<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestDetailedResponse;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\AllPullRequestsResult;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\RepositoryResult;
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
