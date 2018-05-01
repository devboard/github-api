<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\PullRequestFactory;
use DevboardLib\GitHubApi\V4\Repository\PullRequestApi;
use PhpSpec\ObjectBehavior;

class PullRequestApiSpec extends ObjectBehavior
{
    public function let(GitHubClientFactory $clientFactory, PullRequestFactory $pullRequestFactory)
    {
        $this->beConstructedWith($clientFactory, $pullRequestFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestApi::class);
    }
}
