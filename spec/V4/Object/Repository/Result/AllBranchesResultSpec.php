<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\AllBranchesResult;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\RepositoryResult;
use PhpSpec\ObjectBehavior;

class AllBranchesResultSpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, GitHubBranch $branch)
    {
        $this->beConstructedWith($repoFullName, [$branch]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllBranchesResult::class);
        $this->shouldImplement(RepositoryResult::class);
    }
}
