<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\Request\AllPullRequestsQuery;
use DevboardLib\GitHubApi\Query\Repository\Result\AllPullRequestsResult;
use DevboardLib\GitHubApi\V4\Object\Repository\PullRequestObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestDetailedResponseFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\PullRequestObjectApi
 */
class PullRequestObjectApiTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetPullRequests(AllPullRequestsQuery $query, $inputData): void
    {
        $api = Mockery::mock(PullRequestApi::class);
        $api->shouldReceive('handleAllPullRequestsQuery')->andReturn($inputData);

        $api = new PullRequestObjectApi($api, PullRequestDetailedResponseFactoryTest::instance());

        $result = $api->handleAllPullRequestsQuery($query);

        self::assertInstanceOf(AllPullRequestsResult::class, $result);
    }

    public function provideData()
    {
        $provider     = new TestDataProvider();
        $repoFullName = RepoFullName::createFromString('who/cares');
        $credentials  = Mockery::mock(InstallationCredentials::class);

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            $query = new AllPullRequestsQuery($repoFullName, $credentials);
            yield[$query, $data];
        }
    }
}
