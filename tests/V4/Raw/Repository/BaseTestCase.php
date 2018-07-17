<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getClientFactory(): GitHubClientFactory
    {
        if (false === getenv('GITHUB_TEST_APP_ID')) {
            self::markTestSkipped('No AppId');
        }
        if (false === getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH')) {
            self::markTestSkipped('No PrivateKeyPath');
        }

        $appId          = (int) getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');

        $path = 'file://'.__DIR__.'/../../../../'.$privateKeyPath;

        return new GitHubClientFactory(new JwtTokenBuilder($appId, $path));
    }
}
