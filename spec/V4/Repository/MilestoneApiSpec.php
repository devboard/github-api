<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\MilestoneFactory;
use DevboardLib\GitHubApi\V4\Repository\MilestoneApi;
use PhpSpec\ObjectBehavior;

class MilestoneApiSpec extends ObjectBehavior
{
    public function let(GitHubClientFactory $clientFactory, MilestoneFactory $milestoneFactory)
    {
        $this->beConstructedWith($clientFactory, $milestoneFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MilestoneApi::class);
    }
}
