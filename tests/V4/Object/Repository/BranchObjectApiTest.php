<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\Request\AllBranchesQuery;
use DevboardLib\GitHubApi\V4\Object\Repository\BranchObjectApi;
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
    public function testGetBranches(AllBranchesQuery $query, $inputData): void
    {
        $api = Mockery::mock(BranchApi::class);
        $api->shouldReceive('handleAllBranchesQuery')->andReturn($inputData);

        $api = new BranchObjectApi($api, BranchFactoryTest::instance());

        $result = $api->handleAllBranchesQuery($query);

        self::assertNotEmpty($result->getBranches());
    }

    public function provideData()
    {
        $provider     = new TestDataProvider();
        $repoFullName = RepoFullName::createFromString('who/cares');
        $credentials  = Mockery::mock(InstallationCredentials::class);
        $query        = new AllBranchesQuery($repoFullName, $credentials);

        foreach ($provider->getGitHubV4BranchData() as $data) {
            yield[$query, $data];
        }
    }
}
