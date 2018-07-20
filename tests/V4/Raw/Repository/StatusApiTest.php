<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi
 * @group  live
 */
class StatusApiTest extends BaseTestCase
{
    public function testGetBranches(): void
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new StatusApi($this->getClientFactory());

        $data = $api->allBranchStatuses(
            RepoFullName::createFromString('devboard/git-interfaces'),
            InstallationCredentials::create(125958, $userId)
        );

        self::assertNotNull($data);
    }

    public function testGetPullRequests(): void
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new StatusApi($this->getClientFactory());

        $data = $api->allPullRequestStatuses(
            RepoFullName::createFromString('devboard/git-interfaces'),
            InstallationCredentials::create(125958, $userId)
        );

        self::assertNotNull($data);
    }
}
