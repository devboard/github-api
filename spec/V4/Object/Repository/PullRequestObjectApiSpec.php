<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestDetailedResponseFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\PullRequestObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;
use PhpSpec\ObjectBehavior;

class PullRequestObjectApiSpec extends ObjectBehavior
{
    public function let(PullRequestApi $pullRequestApi, PullRequestDetailedResponseFactory $responseFactory)
    {
        $this->beConstructedWith($pullRequestApi, $responseFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestObjectApi::class);
    }
}
