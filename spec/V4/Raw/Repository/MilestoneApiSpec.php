<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;
use PhpSpec\ObjectBehavior;

class MilestoneApiSpec extends ObjectBehavior
{
    public function let(GitHubClientFactory $clientFactory)
    {
        $this->beConstructedWith($clientFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MilestoneApi::class);
    }
}
