<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubLabelCollection;
use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\PullRequest\PullRequestAssigneeCollection;
use DevboardLib\GitHub\PullRequest\PullRequestBody;
use DevboardLib\GitHub\PullRequest\PullRequestClosedAt;
use DevboardLib\GitHub\PullRequest\PullRequestCreatedAt;
use DevboardLib\GitHub\PullRequest\PullRequestId;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\PullRequest\PullRequestState;
use DevboardLib\GitHub\PullRequest\PullRequestTitle;
use DevboardLib\GitHub\PullRequest\PullRequestUpdatedAt;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAuthorFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PullRequestFactory
{
    /** @var PullRequestAuthorFactory */
    private $authorFactory;

    /** @var PullRequestAssigneeFactory */
    private $assigneeFactory;

    /** @var MilestoneFactory */
    private $milestoneFactory;

    /** @var LabelFactory */
    private $labelFactory;

    public function __construct(
        PullRequestAuthorFactory $authorFactory,
        PullRequestAssigneeFactory $assigneeFactory,
        MilestoneFactory $milestoneFactory,
        LabelFactory $labelFactory
    ) {
        $this->authorFactory    = $authorFactory;
        $this->assigneeFactory  = $assigneeFactory;
        $this->milestoneFactory = $milestoneFactory;
        $this->labelFactory     = $labelFactory;
    }

    public function create(array $data): GitHubPullRequest
    {
        if (true === array_key_exists('author_association', $data)) {
            $authorAssociation = $data['author_association'];
        } else {
            $authorAssociation = null;
        }

        $assignee  = null;
        $assignees = new PullRequestAssigneeCollection();

        foreach ($data['assignees']['edges'] as $assigneeItem) {
            $assignees->add($this->assigneeFactory->create($assigneeItem['node']));
        }

        $labels = new GitHubLabelCollection();

        foreach ($data['labels']['edges'] as $labelItem) {
            $labels->add($this->labelFactory->create($labelItem['node']));
        }

        if (null === $data['milestone']) {
            $milestone = null;
        } else {
            $milestone = $this->milestoneFactory->create($data['milestone']);
        }

        if (null === $data['closedAt']) {
            $closedAt = null;
        } else {
            $closedAt = new PullRequestClosedAt($data['closedAt']);
        }
        $id = str_replace('011:PullRequest', '', base64_decode($data['id']));

        return new GitHubPullRequest(
            new PullRequestId((int) $id),
            new PullRequestNumber($data['number']),
            new PullRequestTitle($data['title']),
            new PullRequestBody((string) $data['body']),
            new PullRequestState(strtolower($data['state'])),
            $this->authorFactory->create($data['author'], $authorAssociation),
            $assignee,
            $assignees,
            $labels,
            $milestone,
            $closedAt,
            new PullRequestCreatedAt($data['createdAt']),
            new PullRequestUpdatedAt($data['updatedAt'])
        );
    }
}
