<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Response;

use DevboardLib\GitHub\GitHubLabelCollection;
use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\GitHubPullRequestReviewCollection;
use DevboardLib\GitHub\PullRequest\PullRequestAssigneeCollection;
use DevboardLib\GitHub\PullRequest\PullRequestRequestedReviewerCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestDetailedResponse;
use PhpSpec\ObjectBehavior;

class PullRequestDetailedResponseSpec extends ObjectBehavior
{
    public function let(
        GitHubPullRequest $pullRequest,
        PullRequestAssigneeCollection $assignees,
        PullRequestRequestedReviewerCollection $requestedReviewers,
        GitHubPullRequestReviewCollection $reviews,
        GitHubLabelCollection $labels,
        GitHubMilestone $milestone
    ) {
        $this->beConstructedWith($pullRequest, $assignees, $requestedReviewers, $reviews, $labels, $milestone);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestDetailedResponse::class);
    }
}
