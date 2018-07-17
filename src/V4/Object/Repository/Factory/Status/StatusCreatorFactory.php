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
        if ([] === $data) {
            return new StatusCreator(
                new AccountId(10137),
                new AccountLogin('ghost'),
                AccountType::BOT(),
                new AccountAvatarUrl('https://avatars1.githubusercontent.com/u/10137?v=4'),
                false
            );
        }

        $id = str_replace('04:User', '', base64_decode($data['id'], true));

        return new StatusCreator(
            new AccountId((int) $id),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            new AccountAvatarUrl($data['avatarUrl']),
            $data['isSiteAdmin']
        );
    }
}
