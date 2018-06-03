<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHubApi\Query\Repository\Result\Response\PullRequestDetailedResponse;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestRequestedReviewerCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewCollectionFactory;

class PullRequestDetailedResponseFactory
{
    /** @var \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactory */
    private $pullRequestFactory;

    /** @var PullRequestAssigneeCollectionFactory */
    private $assigneeCollectionFactory;

    /** @var PullRequestRequestedReviewerCollectionFactory */
    private $requestedCollectionFactory;

    /** @var PullRequestReviewCollectionFactory */
    private $reviewCollectionFactory;

    /** @var LabelCollectionFactory */
    private $labelCollectionFactory;

    /** @var \DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactory */
    private $milestoneFactory;

    public function __construct(
        PullRequestFactory $pullRequestFactory,
        PullRequestAssigneeCollectionFactory $assigneeCollectionFactory,
        PullRequestRequestedReviewerCollectionFactory $requestedCollectionFactory,
        PullRequestReviewCollectionFactory $reviewCollectionFactory,
        LabelCollectionFactory $labelCollectionFactory,
        MilestoneFactory $milestoneFactory
    ) {
        $this->pullRequestFactory         = $pullRequestFactory;
        $this->assigneeCollectionFactory  = $assigneeCollectionFactory;
        $this->requestedCollectionFactory = $requestedCollectionFactory;
        $this->reviewCollectionFactory    = $reviewCollectionFactory;
        $this->labelCollectionFactory     = $labelCollectionFactory;
        $this->milestoneFactory           = $milestoneFactory;
    }

    public function create(array $data): PullRequestDetailedResponse
    {
        return new PullRequestDetailedResponse(
            $this->pullRequestFactory->create($data),
            $this->assigneeCollectionFactory->create($data['assignees']['edges']),
            $this->requestedCollectionFactory->create($data['reviewRequests']['edges']),
            $this->reviewCollectionFactory->create($data['reviews']['edges']),
            $this->labelCollectionFactory->create($data['labels']['edges']),
            $this->milestoneFactory->create($data['milestone'])
        );
    }
}
