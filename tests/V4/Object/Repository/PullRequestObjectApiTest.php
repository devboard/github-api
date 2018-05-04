<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\PullRequestObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;
use Github\Api\GraphQL;
use Github\Client;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactoryTest;

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
        $clientFactory = Mockery::mock(GitHubClientFactory::class);
        $client        = Mockery::mock(Client::class);
        $graphQlApi    = Mockery::mock(GraphQL::class);

        $clientFactory->shouldReceive('createAppAndUserAuthenticatedClient')->andReturn($client);
        $client->shouldReceive('graphql')->andReturn($graphQlApi);

        foreach ($inputData as $inputDatum) {
            $graphQlApi->shouldReceive('execute')->andReturn($inputDatum);
        }

        $api = new PullRequestObjectApi(new PullRequestApi($clientFactory), PullRequestFactoryTest::instance());

        $data = $api->getPullRequests($repoFullName, $installationId, $userId);

        self::assertContainsOnlyInstancesOf(GitHubPullRequest::class, $data);
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
                    file_get_contents(__DIR__.'/../../TestData/'.$repository['full_name'].'/pullrequests.json'),
                    true
                );

                yield[$installationId, $userId, $repoFullName, $data];
            }
        }
    }
}
