<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Query\Repository\AllBranchesQuery;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi
 * @group  live
 */
class BranchApiTest extends TestCase
{
    public function testFetch()
    {
        $appId          = getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');
        $userId         = getenv('GITHUB_TEST_USER_ID');

        if (false === $appId) {
            self::markTestSkipped('No AppId');
        }
        if (false === $privateKeyPath) {
            self::markTestSkipped('No PrivateKeyPath');
        }
        if (false === $userId) {
            self::markTestSkipped('No user id');
        }
        $path = 'file://'.__DIR__.'/../../../../'.$privateKeyPath;

        $clientFactory = new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path));

        $api = new BranchApi($clientFactory);

        $allBranchesQuery = AllBranchesQuery::create('devboard/git-interfaces', 125958, (int) $userId);

        $data = $api->getBranches($allBranchesQuery);

        self::assertNotNull($data);
    }
}
