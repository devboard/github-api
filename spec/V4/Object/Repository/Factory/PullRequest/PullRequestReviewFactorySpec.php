<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewFactory;
use PhpSpec\ObjectBehavior;

class PullRequestReviewFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestReviewFactory::class);
    }
}
