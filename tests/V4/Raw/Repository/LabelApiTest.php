<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllLabelsQuery;
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

        $query = AllLabelsQuery::create('devboard/git-interfaces', 125958, $userId);
        $data  = $api->getLabels($query);

        self::assertNotNull($data);
    }
}
