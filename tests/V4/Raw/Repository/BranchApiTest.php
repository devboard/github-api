<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\V4\Query\Repository\AllBranchesQuery;
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

        $allBranchesQuery = AllBranchesQuery::create('devboard/git-interfaces', 125958, $userId);

        $data = $api->getBranches($allBranchesQuery);

        self::assertNotNull($data);
    }
}
