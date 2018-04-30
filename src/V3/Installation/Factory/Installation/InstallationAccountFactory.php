<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation\Factory\Installation;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Installation\InstallationAccount;

/**
 * @see InstallationAccountFactorySpec
 * @see InstallationAccountFactoryTest
 */
class InstallationAccountFactory
{
    public function create(array $data): InstallationAccount
    {
        return new InstallationAccount(
            new AccountId($data['id']),
            new AccountLogin($data['login']),
            new AccountType($data['type']),
            new AccountAvatarUrl($data['avatar_url']),
            $data['site_admin']
        );
    }
}
