<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Query\Repository\Result\AllBranchStatusesResult;
use DevboardLib\GitHubApi\Query\Repository\Result\RepositoryResult;
use DevboardLib\GitHubApi\Query\Repository\Result\Response\BranchStatusCollection;
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
