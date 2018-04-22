<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Repo\RepoOwner;
use DevboardLib\GitHub\User\UserApiUrl;
use DevboardLib\GitHub\User\UserAvatarUrl;
use DevboardLib\GitHub\User\UserHtmlUrl;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHub\User\UserLogin;

/**
 * @see RepoOwnerFactorySpec
 * @see RepoOwnerFactoryTest
 */
class RepoOwnerFactory
{
    public function create(array $data): RepoOwner
    {
        return new RepoOwner(
            new UserId($data['owner']['id']),
            new UserLogin($data['owner']['login']),
            new AccountType($data['owner']['type']),
            new UserAvatarUrl($data['owner']['avatar_url']),
            null,
            new UserHtmlUrl($data['owner']['html_url']),
            new UserApiUrl($data['owner']['url']),
            $data['owner']['site_admin']
        );
    }
}
