<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\GitHubPullRequestReview;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewAuthor;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewAuthorAssociation;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewBody;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewId;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewState;
use DevboardLib\GitHub\PullRequestReview\PullRequestReviewSubmittedAt;

class PullRequestReviewFactory
{
    public function create(array $data): GitHubPullRequestReview
    {
        if (true === array_key_exists('authorAssociation', $data)) {
            $authorAssociation = $data['authorAssociation'];
        } else {
            $authorAssociation = null;
        }

        if (null === $data['submittedAt']) {
            $submittedAt = null;
        } else {
            $submittedAt = new PullRequestReviewSubmittedAt($data['submittedAt']);
        }

        $id = str_replace('017:PullRequestReview', '', base64_decode($data['id'], true));

        return new GitHubPullRequestReview(
            new PullRequestReviewId((int) $id),
            new PullRequestReviewBody((string) $data['body']),
            $this->createAuthor($data['author'], $authorAssociation),
            new PullRequestReviewState(strtolower($data['state'])),
            new CommitSha($data['commit']['oid']),
            $submittedAt
        );
    }

    public function createAuthor(array $data, ?string $association = null): PullRequestReviewAuthor
    {
        if (null === $association) {
            $authorAssociation = null;
        } else {
            $authorAssociation = new PullRequestReviewAuthorAssociation($association);
        }

        $id = str_replace('04:User', '', base64_decode($data['id'], true));

        return new PullRequestReviewAuthor(
            new AccountId((int) $id),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            $authorAssociation,
            new AccountAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
