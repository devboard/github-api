<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\BranchStatusCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\AllBranchStatusesResult;
use DevboardLib\GitHubApi\V4\Object\Repository\Result\RepositoryResult;
use PhpSpec\ObjectBehavior;

class AllBranchStatusesResultSpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, BranchStatusCollection $branchStatusCollection)
    {
        $this->beConstructedWith($repoFullName, [$branchStatusCollection]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllBranchStatusesResult::class);
        $this->shouldImplement(RepositoryResult::class);
    }
}
