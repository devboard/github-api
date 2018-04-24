<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHubApi\V4\Repository\Factory\BranchFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\CommitFactory;
use PhpSpec\ObjectBehavior;

class BranchFactorySpec extends ObjectBehavior
{
    public function let(CommitFactory $commitFactory)
    {
        $this->beConstructedWith($commitFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BranchFactory::class);
    }
}
