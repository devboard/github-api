<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\Repo;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Repo\RepoOwner;

class RepoOwnerFactory
{
    public function create(array $data): RepoOwner
    {
        return new RepoOwner(
            new AccountId((int) $data['id']),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            new AccountAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
