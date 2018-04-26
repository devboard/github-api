<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHubApi\V4\Repository\Factory\MilestoneFactory;
use PhpSpec\ObjectBehavior;

class MilestoneFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MilestoneFactory::class);
    }
}
