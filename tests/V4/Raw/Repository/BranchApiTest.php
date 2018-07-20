<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi
 * @group  live
 */
class BranchApiTest extends BaseTestCase
{
    public function testGetBranches(): void
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new BranchApi($this->getClientFactory());

        $data = $api->allBranches(
            RepoFullName::createFromString('devboard/git-interfaces'),
            InstallationCredentials::create(125958, $userId)
        );

        self::assertNotNull($data);
    }
}
