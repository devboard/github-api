<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi
 * @group live
 */
class LabelApiTest extends BaseTestCase
{
    public function testFetch(): void
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new LabelApi($this->getClientFactory());

        $data = $api->allLabels(
            RepoFullName::createFromString('devboard/git-interfaces'),
            InstallationCredentials::create(125958, $userId)
        );

        self::assertNotNull($data);
    }
}
