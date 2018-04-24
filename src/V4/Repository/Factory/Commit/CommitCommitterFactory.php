<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository\Factory\Commit;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\Committer\CommitterName;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Commit\CommitCommitter;
use DevboardLib\GitHub\Commit\CommitCommitterDetails;
use DevboardLib\GitHub\User\UserApiUrl;
use DevboardLib\GitHub\User\UserAvatarUrl;
use DevboardLib\GitHub\User\UserHtmlUrl;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHub\User\UserLogin;

/**
 * @see CommitCommitterFactorySpec
 * @see CommitCommitterFactoryTest
 */
class CommitCommitterFactory
{
    public function createFromBranchData(array $data): CommitCommitter
    {
        if (null === $data['user']) {
            $committerDetails = null;
        } else {
            $committerDetails = new CommitCommitterDetails(
                new UserId((int) $data['user']['id']),
                new UserLogin($data['user']['login']),
                new AccountType($data['user']['__typename']),
                new UserAvatarUrl($data['user']['avatarUrl']),
                null,
                new UserHtmlUrl('TODO'),
                new UserApiUrl('TODO'),
                $data['user']['isSiteAdmin']
            );
        }

        return new CommitCommitter(
            new CommitterName($data['name']),
            new EmailAddress($data['email']),
            new CommitDate($data['date']),
            $committerDetails
        );
    }
}
