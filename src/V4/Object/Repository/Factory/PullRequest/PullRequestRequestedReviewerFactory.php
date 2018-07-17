<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\PullRequest\PullRequestRequestedReviewer;
use DevboardLib\GitHub\User\UserAvatarUrl;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHub\User\UserLogin;

/**
 * @see GitHubPullRequestRequestedReviewerFactorySpec
 * @see GitHubPullRequestRequestedReviewerFactoryTest
 */
class PullRequestRequestedReviewerFactory
{
    public function create(array $data): PullRequestRequestedReviewer
    {
        $id = str_replace('04:User', '', base64_decode($data['id'], true));

        return new PullRequestRequestedReviewer(
            new UserId((int) $id),
            new UserLogin($data['login']),
            new AccountType($data['__typename']),
            new UserAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
