<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository\Factory\Commit;

use DevboardLib\Generix\EmailAddress;
use DevboardLib\Git\Commit\Author\AuthorName;
use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Commit\CommitAuthor;
use DevboardLib\GitHub\Commit\CommitAuthorDetails;
use DevboardLib\GitHub\User\UserApiUrl;
use DevboardLib\GitHub\User\UserAvatarUrl;
use DevboardLib\GitHub\User\UserHtmlUrl;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHub\User\UserLogin;

/**
 * @see CommitAuthorFactorySpec
 * @see CommitAuthorFactoryTest
 */
class CommitAuthorFactory
{
    public function createFromBranchData(array $data): CommitAuthor
    {
        if (null === $data['user']) {
            $authorDetails = null;
        } else {
            $authorDetails = new CommitAuthorDetails(
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

        return new CommitAuthor(
            new AuthorName($data['name']),
            new EmailAddress($data['email']),
            new CommitDate($data['date']),
            $authorDetails
        );
    }
}
