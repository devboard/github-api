<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V4\Object\Repository\BranchObjectApi;
use DevboardLib\GitHubApi\V4\Query\Repository\AllBranchesQuery;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\BranchFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\BranchObjectApi
 */
class BranchObjectApiTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetBranches(AllBranchesQuery $query, $inputData)
    {
        $api = Mockery::mock(BranchApi::class);
        $api->shouldReceive('getBranches')->andReturn($inputData);

        $api = new BranchObjectApi($api, BranchFactoryTest::instance());

        $data = $api->getBranches($query);

        self::assertNotEmpty($data);
        self::assertContainsOnlyInstancesOf(GitHubBranch::class, $data);
    }

    public function provideData()
    {
        $provider     = new TestDataProvider();
        $repoFullName = RepoFullName::createFromString('who/cares');
        $credentials  = Mockery::mock(InstallationCredentials::class);

        foreach ($provider->getGitHubV4BranchData() as $data) {
            $query = new AllBranchesQuery($repoFullName, $credentials);

            yield[$query, $data];
        }
    }
}
