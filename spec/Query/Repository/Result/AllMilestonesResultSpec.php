<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Query\Repository\Result\AllMilestonesResult;
use DevboardLib\GitHubApi\Query\Repository\Result\RepositoryResult;
use PhpSpec\ObjectBehavior;

class AllMilestonesResultSpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, GitHubMilestone $milestone)
    {
        $this->beConstructedWith($repoFullName, [$milestone]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllMilestonesResult::class);
        $this->shouldImplement(RepositoryResult::class);
    }
}
