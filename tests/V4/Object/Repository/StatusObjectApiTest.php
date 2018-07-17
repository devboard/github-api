<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\Request\AllBranchStatusesQuery;
use DevboardLib\GitHubApi\Query\Repository\Request\AllPullRequestStatusesQuery;
use DevboardLib\GitHubApi\Query\Repository\Result\AllPullRequestStatusesResult;
use DevboardLib\GitHubApi\V4\Object\Repository\StatusObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;
use Generator;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\StatusObjectApi
 */
class StatusObjectApiTest extends TestCase
{
    /**
     * @dataProvider provideBranchesData
     */
    public function testGetBranches(AllBranchStatusesQuery $query, array $inputData): void
    {
        $api = Mockery::mock(StatusApi::class);
        $api->shouldReceive('handleAllBranchStatusesQuery')->andReturn($inputData);

        $api = new StatusObjectApi($api, StatusFactoryTest::instance());

        $result = $api->handleAllBranchStatusesQuery($query);

        self::assertNotEmpty($result->getBranchStatusCollections());
    }

    public function provideBranchesData(): Generator
    {
        $provider     = new TestDataProvider();
        $repoFullName = RepoFullName::createFromString('who/cares');
        $credentials  = Mockery::mock(InstallationCredentials::class);
        $query        = new AllBranchStatusesQuery($repoFullName, $credentials);

        foreach ($provider->getGitHubV4BranchStatusData() as $data) {
            yield[$query, $data];
        }
    }

    /**
     * @dataProvider providePullRequestsData
     */
    public function testGetPullRequests(AllPullRequestStatusesQuery $query, array $inputData): void
    {
        $api = Mockery::mock(StatusApi::class);
        $api->shouldReceive('handleAllPullRequestStatusesQuery')->andReturn($inputData);

        $api = new StatusObjectApi($api, StatusFactoryTest::instance());

        $result = $api->handleAllPullRequestStatusesQuery($query);

        self::assertInstanceOf(AllPullRequestStatusesResult::class, $result);
    }

    public function providePullRequestsData(): Generator
    {
        $provider     = new TestDataProvider();
        $repoFullName = RepoFullName::createFromString('who/cares');
        $credentials  = Mockery::mock(InstallationCredentials::class);
        $query        = new AllPullRequestStatusesQuery($repoFullName, $credentials);

        foreach ($provider->getGitHubV4PullRequestStatusData() as $data) {
            yield[$query, $data];
        }
    }
}
