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
        $userId   = getenv('GITHUB_TEST_USER_ID');
        $username = getenv('GITHUB_TEST_USERNAME');

        if (false === $userId) {
            self::markTestSkipped('No user id');
        }

        if (false === $username) {
            self::markTestSkipped('No username');
        }
        $userId = new UserId((int) $userId);

        $installations = json_decode(
            file_get_contents(__DIR__.'/../../../V3/TestData/'.$username.'/installations.json'), true
        );

        foreach ($installations['installations'] as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode(
                file_get_contents(__DIR__.'/../../../V3/TestData/'.$vendorName.'/installation-repositories.json'),
                true
            );

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                $data = json_decode(
                    file_get_contents(__DIR__.'/../../TestData/'.$repository['full_name'].'/branch_statuses.json'),
                    true
                );

                yield[$installationId, $userId, $repoFullName, $data];
            }
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
        $userId   = getenv('GITHUB_TEST_USER_ID');
        $username = getenv('GITHUB_TEST_USERNAME');

        if (false === $userId) {
            self::markTestSkipped('No user id');
        }

        if (false === $username) {
            self::markTestSkipped('No username');
        }
        $userId = new UserId((int) $userId);

        $installations = json_decode(
            file_get_contents(__DIR__.'/../../../V3/TestData/'.$username.'/installations.json'), true
        );

        foreach ($installations['installations'] as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode(
                file_get_contents(__DIR__.'/../../../V3/TestData/'.$vendorName.'/installation-repositories.json'),
                true
            );

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                $data = json_decode(
                    file_get_contents(__DIR__.'/../../TestData/'.$repository['full_name'].'/pullrequest_statuses.json'),
                    true
                );

                yield[$installationId, $userId, $repoFullName, $data];
            }
        }
    }
}
