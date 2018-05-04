<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\StatusObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;
use PhpSpec\ObjectBehavior;

class StatusObjectApiSpec extends ObjectBehavior
{
    public function let(StatusApi $branchApi, StatusFactory $statusFactory)
    {
        $this->beConstructedWith($branchApi, $statusFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(StatusObjectApi::class);
    }
}
