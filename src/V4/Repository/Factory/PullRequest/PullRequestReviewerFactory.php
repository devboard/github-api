<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository\Factory\PullRequest;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\PullRequest\PullRequestReviewer;

/**
 * @see GitHubPullRequestReviewerFactorySpec
 * @see GitHubPullRequestReviewerFactoryTest
 */
class PullRequestReviewerFactory
{
    public function create(array $data): PullRequestReviewer
    {
        return new PullRequestReviewer(
            new AccountId((int) $data['id']),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            new AccountAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
