<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi
 * @group live
 */
class MilestoneApiTest extends TestCase
{
    public function testFetch()
    {
        $appId          = getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');
        $userId         = getenv('GITHUB_TEST_USER_ID');
        $username       = getenv('GITHUB_TEST_USERNAME');
        $token          = getenv('GITHUB_TEST_TOKEN');

        if (false === $appId) {
            self::markTestSkipped('No AppId');
        }
        if (false === $privateKeyPath) {
            self::markTestSkipped('No PrivateKeyPath');
        }
        if (false === $userId) {
            self::markTestSkipped('No user id');
        }
        if (false === $username) {
            self::markTestSkipped('No username');
        }
        if (false === $token) {
            self::markTestSkipped('No token');
        }
        $path = 'file://'.__DIR__.'/../../../../'.$privateKeyPath;

        $clientFactory = new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path));

        $api = new MilestoneApi($clientFactory);

        $repoFullName = RepoFullName::createFromString('devboard/git-interfaces');
        $data         = $api->getMilestones($repoFullName, new InstallationId(125958), new UserId((int) $userId));

        self::assertNotNull($data);
    }
}
