<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\PullRequest\PullRequestBody;
use DevboardLib\GitHub\PullRequest\PullRequestClosedAt;
use DevboardLib\GitHub\PullRequest\PullRequestCreatedAt;
use DevboardLib\GitHub\PullRequest\PullRequestId;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHub\PullRequest\PullRequestState;
use DevboardLib\GitHub\PullRequest\PullRequestTitle;
use DevboardLib\GitHub\PullRequest\PullRequestUpdatedAt;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAuthorFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PullRequestFactory
{
    /** @var PullRequestAuthorFactory */
    private $authorFactory;

    public function __construct(PullRequestAuthorFactory $authorFactory)
    {
        $this->authorFactory = $authorFactory;
    }

    public function create(array $data): GitHubPullRequest
    {
        if (true === array_key_exists('author_association', $data)) {
            $authorAssociation = $data['author_association'];
        } else {
            $authorAssociation = null;
        }

        if (null === $data['closedAt']) {
            $closedAt = null;
        } else {
            $closedAt = new PullRequestClosedAt($data['closedAt']);
        }
        $id = str_replace('011:PullRequest', '', base64_decode($data['id'], true));

        return new GitHubPullRequest(
            new PullRequestId((int) $id),
            new PullRequestNumber($data['number']),
            new PullRequestTitle($data['title']),
            new PullRequestBody((string) $data['body']),
            new PullRequestState(strtolower($data['state'])),
            $this->authorFactory->create($data['author'], $authorAssociation),
            $closedAt,
            new PullRequestCreatedAt($data['createdAt']),
            new PullRequestUpdatedAt($data['updatedAt'])
        );
    }
}
