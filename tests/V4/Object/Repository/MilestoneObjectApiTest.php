<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\AllMilestonesQuery;
use DevboardLib\GitHubApi\V4\Object\Repository\MilestoneObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\MilestoneObjectApi
 */
class MilestoneObjectApiTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetMilestones(AllMilestonesQuery $query, $inputData)
    {
        $api = Mockery::mock(MilestoneApi::class);
        $api->shouldReceive('getMilestones')->andReturn($inputData);

        $api = new MilestoneObjectApi($api, MilestoneFactoryTest::instance());

        $data = $api->getMilestones($query);

        self::assertContainsOnlyInstancesOf(GitHubMilestone::class, $data);
    }

    public function provideData()
    {
        $provider     = new TestDataProvider();
        $repoFullName = RepoFullName::createFromString('who/cares');
        $credentials  = Mockery::mock(InstallationCredentials::class);
        $query        = new AllMilestonesQuery($repoFullName, $credentials);

        foreach ($provider->getGitHubV4MilestoneData() as $data) {
            yield[$query, $data];
        }
    }
}
