<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestRequestedReviewerCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestDetailedResponseFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactory;
use PhpSpec\ObjectBehavior;

class PullRequestDetailedResponseFactorySpec extends ObjectBehavior
{
    public function let(
        PullRequestFactory $pullRequestFactory,
        PullRequestAssigneeCollectionFactory $assigneeCollectionFactory,
        PullRequestRequestedReviewerCollectionFactory $requestedReviewerCollectionFactory,
        PullRequestReviewCollectionFactory $requestReviewCollectionFactory,
        LabelCollectionFactory $labelCollectionFactory,
        MilestoneFactory $milestoneFactory
    ) {
        $this->beConstructedWith(
            $pullRequestFactory,
            $assigneeCollectionFactory,
            $requestedReviewerCollectionFactory,
            $requestReviewCollectionFactory,
            $labelCollectionFactory,
            $milestoneFactory
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestDetailedResponseFactory::class);
    }
}
