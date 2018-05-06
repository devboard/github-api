<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewFactory;
use PhpSpec\ObjectBehavior;

class PullRequestReviewCollectionFactorySpec extends ObjectBehavior
{
    public function let(PullRequestReviewFactory $reviewFactory)
    {
        $this->beConstructedWith($reviewFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestReviewCollectionFactory::class);
    }
}
