<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
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
    public function testGetBranches(
        InstallationId $installationId, UserId $userId, RepoFullName $repoFullName, $inputData
    ) {
        $api = Mockery::mock(StatusApi::class);
        $api->shouldReceive('getBranches')->andReturn($inputData);

        $api = new StatusObjectApi($api, StatusFactoryTest::instance());

        $data = $api->getBranches($repoFullName, $installationId, $userId);

        self::assertNotEmpty($data);
        self::assertContainsOnlyInstancesOf(BranchStatusCollection::class, $data);
    }

    public function provideBranchesData()
    {
        $provider       = new TestDataProvider();
        $repoFullName   = RepoFullName::createFromString('who/cares');
        $installationId = new InstallationId(12345666);
        $userId         = new UserId(123);

        foreach ($provider->getGitHubV4BranchStatusData() as $data) {
            yield[$installationId, $userId, $repoFullName, $data];
        }
    }

    /**
     * @dataProvider providePullRequestsData
     */
    public function testGetPullRequests(
        InstallationId $installationId, UserId $userId, RepoFullName $repoFullName, $inputData
    ) {
        $api = Mockery::mock(StatusApi::class);
        $api->shouldReceive('getPullRequests')->andReturn($inputData);

        $api = new StatusObjectApi($api, StatusFactoryTest::instance());

        $data = $api->getPullRequests($repoFullName, $installationId, $userId);

        self::assertContainsOnlyInstancesOf(PullRequestStatusCollection::class, $data);
    }

    public function providePullRequestsData()
    {
        $provider       = new TestDataProvider();
        $repoFullName   = RepoFullName::createFromString('who/cares');
        $installationId = new InstallationId(12345666);
        $userId         = new UserId(123);

        foreach ($provider->getGitHubV4PullRequestStatusData() as $data) {
            yield[$installationId, $userId, $repoFullName, $data];
        }
    }
}
