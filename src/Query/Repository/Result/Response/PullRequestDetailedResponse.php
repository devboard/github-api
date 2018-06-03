<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result\Response;

use DevboardLib\GitHub\GitHubLabelCollection;
use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\GitHubPullRequestReviewCollection;
use DevboardLib\GitHub\PullRequest\PullRequestAssigneeCollection;
use DevboardLib\GitHub\PullRequest\PullRequestRequestedReviewerCollection;

class PullRequestDetailedResponse
{
    /** @var GitHubPullRequest */
    private $pullRequest;

    /** @var PullRequestAssigneeCollection */
    private $assignees;

    /** @var PullRequestRequestedReviewerCollection */
    private $requestedReviewers;

    /** @var GitHubPullRequestReviewCollection */
    private $reviews;

    /** @var GitHubLabelCollection */
    private $labels;

    /** @var GitHubMilestone|null */
    private $milestone;

    public function __construct(
        GitHubPullRequest $pullRequest,
        PullRequestAssigneeCollection $assignees,
        PullRequestRequestedReviewerCollection $requestedReviewers,
        GitHubPullRequestReviewCollection $reviews,
        GitHubLabelCollection $labels,
        ?GitHubMilestone $milestone
    ) {
        $this->pullRequest        = $pullRequest;
        $this->assignees          = $assignees;
        $this->requestedReviewers = $requestedReviewers;
        $this->reviews            = $reviews;
        $this->labels             = $labels;
        $this->milestone          = $milestone;
    }

    public function getPullRequest(): GitHubPullRequest
    {
        return $this->pullRequest;
    }

    public function getAssignees(): PullRequestAssigneeCollection
    {
        return $this->assignees;
    }

    public function getRequestedReviewers(): PullRequestRequestedReviewerCollection
    {
        return $this->requestedReviewers;
    }

    public function getReviews(): GitHubPullRequestReviewCollection
    {
        return $this->reviews;
    }

    public function getLabels(): GitHubLabelCollection
    {
        return $this->labels;
    }

    public function getMilestone(): ?GitHubMilestone
    {
        return $this->milestone;
    }

    public function serialize(): array
    {
        if (null === $this->milestone) {
            $milestone = null;
        } else {
            $milestone = $this->milestone->serialize();
        }

        return [
            'pullRequest'        => $this->pullRequest->serialize(),
            'assignees'          => $this->assignees->serialize(),
            'requestedReviewers' => $this->requestedReviewers->serialize(),
            'reviews'            => $this->reviews->serialize(),
            'labels'             => $this->labels->serialize(),
            'milestone'          => $milestone,
        ];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['milestone']) {
            $milestone = null;
        } else {
            $milestone = GitHubMilestone::deserialize($data['milestone']);
        }

        return new self(
            GitHubPullRequest::deserialize($data['pullRequest']),
            PullRequestAssigneeCollection::deserialize($data['assignees']),
            PullRequestRequestedReviewerCollection::deserialize($data['requestedReviewers']),
            GitHubPullRequestReviewCollection::deserialize($data['reviews']),
            GitHubLabelCollection::deserialize($data['labels']),
            $milestone
        );
    }
}
