<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\BranchApi;
use DevboardLib\GitHubApi\V4\Repository\Factory\BranchFactory;
use PhpSpec\ObjectBehavior;

class BranchApiSpec extends ObjectBehavior
{
    public function let(GitHubClientFactory $clientFactory, BranchFactory $branchFactory)
    {
        $this->beConstructedWith($clientFactory, $branchFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchApi::class);
    }
}
