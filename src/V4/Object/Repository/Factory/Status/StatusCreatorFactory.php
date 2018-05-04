<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status;

use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\Status\StatusCreator;

class StatusCreatorFactory
{
    public function create(array $data): StatusCreator
    {
        return new StatusCreator(
            new AccountId((int) $data['id']),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            new AccountAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
