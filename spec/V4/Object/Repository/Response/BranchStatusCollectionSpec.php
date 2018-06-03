<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Response;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\GitHubStatus;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\BranchStatusCollection;
use PhpSpec\ObjectBehavior;

class BranchStatusCollectionSpec extends ObjectBehavior
{
    public function let(BranchName $branchName, CommitSha $sha, GitHubStatus $status1)
    {
        $this->beConstructedWith($branchName, $sha, [$status1]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchStatusCollection::class);
    }
}
