<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\V4\Object\Repository\BranchObjectApi;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\BranchFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;
use PhpSpec\ObjectBehavior;

class BranchObjectApiSpec extends ObjectBehavior
{
    public function let(BranchApi $branchApi, BranchFactory $branchFactory)
    {
        $this->beConstructedWith($branchApi, $branchFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchObjectApi::class);
    }
}
