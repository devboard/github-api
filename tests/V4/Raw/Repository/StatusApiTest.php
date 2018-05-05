<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi
 * @group live
 */
class StatusApiTest extends BaseTestCase
{
    public function testGetBranches()
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new StatusApi($this->getClientFactory());

        $repoFullName = RepoFullName::createFromString('devboard/git-interfaces');
        $data         = $api->getBranches($repoFullName, new InstallationId(125958), new UserId($userId));

        self::assertNotNull($data);
    }

    public function testGetPullRequests()
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new StatusApi($this->getClientFactory());

        $repoFullName = RepoFullName::createFromString('devboard/git-interfaces');
        $data         = $api->getPullRequests($repoFullName, new InstallationId(125958), new UserId($userId));

        self::assertNotNull($data);
    }
}
