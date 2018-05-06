<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeFactory;
use PhpSpec\ObjectBehavior;

class PullRequestAssigneeCollectionFactorySpec extends ObjectBehavior
{
    public function let(PullRequestAssigneeFactory $assigneeFactory)
    {
        $this->beConstructedWith($assigneeFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestAssigneeCollectionFactory::class);
    }
}
