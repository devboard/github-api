<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestRequestedReviewerCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestRequestedReviewerFactory;
use PhpSpec\ObjectBehavior;

class PullRequestRequestedReviewerCollectionFactorySpec extends ObjectBehavior
{
    public function let(PullRequestRequestedReviewerFactory $requestedReviewerFactory)
    {
        $this->beConstructedWith($requestedReviewerFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestRequestedReviewerCollectionFactory::class);
    }
}
