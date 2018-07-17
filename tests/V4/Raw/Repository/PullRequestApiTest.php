<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllPullRequestsQuery;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi
 * @group live
 */
class PullRequestApiTest extends BaseTestCase
{
    public function testFetch(): void
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new PullRequestApi($this->getClientFactory());

        $query = AllPullRequestsQuery::create('devboard/git-interfaces', 125958, $userId);

        $data = $api->handleAllPullRequestsQuery($query);

        self::assertNotNull($data);
        self::assertEquals(1, count($data));
    }
}
