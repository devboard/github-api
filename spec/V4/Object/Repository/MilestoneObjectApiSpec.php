<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\MilestoneObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;
use PhpSpec\ObjectBehavior;

class MilestoneObjectApiSpec extends ObjectBehavior
{
    public function let(MilestoneApi $milestoneApi, MilestoneFactory $milestoneFactory)
    {
        $this->beConstructedWith($milestoneApi, $milestoneFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MilestoneObjectApi::class);
    }
}
