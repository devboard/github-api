<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi
 * @group live
 */
class LabelApiTest extends BaseTestCase
{
    public function testFetch()
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new LabelApi($this->getClientFactory());

        $repoFullName = RepoFullName::createFromString('devboard/git-interfaces');
        $data         = $api->getLabels($repoFullName, new InstallationId(125958), new UserId($userId));

        self::assertNotNull($data);
    }
}
