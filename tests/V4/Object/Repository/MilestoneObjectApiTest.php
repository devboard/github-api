<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Object\Repository\MilestoneObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactoryTest;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\MilestoneObjectApi
 */
class MilestoneObjectApiTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetMilestones(
        InstallationId $installationId, UserId $userId, RepoFullName $repoFullName, $inputData
    ) {
        $api = Mockery::mock(MilestoneApi::class);
        $api->shouldReceive('getMilestones')->andReturn($inputData);

        $api = new MilestoneObjectApi($api, MilestoneFactoryTest::instance());

        $data = $api->getMilestones($repoFullName, $installationId, $userId);

        self::assertContainsOnlyInstancesOf(GitHubMilestone::class, $data);
    }

    public function provideData()
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
                    file_get_contents(__DIR__.'/../../TestData/'.$repository['full_name'].'/milestones.json'), true
                );

                yield[$installationId, $userId, $repoFullName, $data];
            }
        }
    }
}
