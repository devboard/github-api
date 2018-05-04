<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\PullRequest\PullRequestAssignee;

/**
 * @see GitHubPullRequestAssigneeFactorySpec
 * @see GitHubPullRequestAssigneeFactoryTest
 */
class PullRequestAssigneeFactory
{
    public function create(array $data): PullRequestAssignee
    {
        $id = str_replace('04:User', '', base64_decode($data['id']));

        return new PullRequestAssignee(
            new AccountId((int) $id),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            new AccountAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
