<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\AllBranchStatusesQuery;
use DevboardLib\GitHubApi\Query\Repository\AllPullRequestStatusesQuery;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\BranchStatusCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestStatusCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\StatusObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;
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
    public function testGetBranches(AllBranchStatusesQuery $query, $inputData)
    {
        $api = Mockery::mock(StatusApi::class);
        $api->shouldReceive('getBranches')->andReturn($inputData);

        $api = new StatusObjectApi($api, StatusFactoryTest::instance());

        $data = $api->getBranches($query);

        self::assertNotEmpty($data);
        self::assertContainsOnlyInstancesOf(BranchStatusCollection::class, $data);
    }

    public function provideBranchesData()
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
    public function testGetPullRequests(AllPullRequestStatusesQuery $query, $inputData)
    {
        $api = Mockery::mock(StatusApi::class);
        $api->shouldReceive('getPullRequests')->andReturn($inputData);

        $api = new StatusObjectApi($api, StatusFactoryTest::instance());

        $data = $api->getPullRequests($query);

        self::assertContainsOnlyInstancesOf(PullRequestStatusCollection::class, $data);
    }

    public function providePullRequestsData()
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
