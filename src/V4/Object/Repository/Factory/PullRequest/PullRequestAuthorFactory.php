<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\PullRequest\PullRequestAuthor;
use DevboardLib\GitHub\PullRequest\PullRequestAuthorAssociation;

/**
 * @see GitHubPullRequestAuthorFactorySpec
 * @see GitHubPullRequestAuthorFactoryTest
 */
class PullRequestAuthorFactory
{
    public function create(array $data, ?string $association = null): PullRequestAuthor
    {
        if (empty($data)) {
            return new PullRequestAuthor(
                new AccountId(10137),
                new AccountLogin('ghost'),
                new AccountType('User'),
                null,
                new AccountAvatarUrl('https://avatars3.githubusercontent.com/u/10137?v=4'),
                false
            );
        }

        $id = str_replace('04:User', '', base64_decode($data['id']));

        if (null === $association) {
            $authorAssociation = null;
        } else {
            $authorAssociation = new PullRequestAuthorAssociation($association);
        }

        return new PullRequestAuthor(
            new AccountId((int) $id),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            $authorAssociation,
            new AccountAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
