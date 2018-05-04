<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\PullRequestObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;
use PhpSpec\ObjectBehavior;

class PullRequestObjectApiSpec extends ObjectBehavior
{
    public function let(PullRequestApi $pullRequestApi, PullRequestFactory $pullRequestFactory)
    {
        $this->beConstructedWith($pullRequestApi, $pullRequestFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestObjectApi::class);
    }
}
