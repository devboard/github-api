<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllBranchesQuery;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;

/**
 * @covers \DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi
 * @group  live
 */
class BranchApiTest extends BaseTestCase
{
    public function testGetBranches()
    {
        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        $userId = (int) getenv('GITHUB_TEST_USER_ID');

        $api = new BranchApi($this->getClientFactory());

        $query = AllBranchesQuery::create('devboard/git-interfaces', 125958, $userId);

        $data = $api->handleAllBranchesQuery($query);

        self::assertNotNull($data);
    }
}
