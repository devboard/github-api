<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Object\Repository\PullRequestObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\PullRequestObjectApi
 */
class PullRequestObjectApiTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetPullRequests(
        InstallationId $installationId, UserId $userId, RepoFullName $repoFullName, $inputData
    ) {
        $api = Mockery::mock(PullRequestApi::class);
        $api->shouldReceive('getPullRequests')->andReturn($inputData);

        $api = new PullRequestObjectApi($api, PullRequestFactoryTest::instance());

        $data = $api->getPullRequests($repoFullName, $installationId, $userId);

        self::assertContainsOnlyInstancesOf(GitHubPullRequest::class, $data);
    }

    public function provideData()
    {
        $provider       = new TestDataProvider();
        $repoFullName   = RepoFullName::createFromString('who/cares');
        $installationId = new InstallationId(12345666);
        $userId         = new UserId(123);

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            yield[$installationId, $userId, $repoFullName, $data];
        }
    }
}
