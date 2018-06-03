<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllBranchStatusesQuery;
use DevboardLib\GitHubApi\Query\Repository\Request\AllPullRequestStatusesQuery;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi
 * @group  live
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

        $query = AllBranchStatusesQuery::create('devboard/git-interfaces', 125958, $userId);
        $data  = $api->handleAllBranchStatusesQuery($query);

        self::assertNotNull($data);
    }

    public function testGetPullRequests()
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new StatusApi($this->getClientFactory());

        $query = AllPullRequestStatusesQuery::create('devboard/git-interfaces', 125958, $userId);
        $data  = $api->handleAllPullRequestStatusesQuery($query);

        self::assertNotNull($data);
    }
}
