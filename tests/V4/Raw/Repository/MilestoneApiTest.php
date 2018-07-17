<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllMilestonesQuery;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi
 * @group  live
 */
class MilestoneApiTest extends BaseTestCase
{
    public function testFetch(): void
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new MilestoneApi($this->getClientFactory());

        $query = AllMilestonesQuery::create('devboard/git-interfaces', 125958, $userId);
        $data  = $api->handleAllMilestonesQuery($query);

        self::assertNotNull($data);
    }
}
