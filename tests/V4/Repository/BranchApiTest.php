<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\BranchApi;
use Github\Api\GraphQL;
use Github\Client;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Repository\Factory\BranchFactoryTest;

/**
 * @covers \DevboardLib\GitHubApi\V4\Repository\BranchApi
 */
class BranchApiTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetBranches(
        InstallationId $installationId, UserId $userId, RepoFullName $repoFullName, $inputData
    ) {
        $clientFactory = Mockery::mock(GitHubClientFactory::class);
        $client        = Mockery::mock(Client::class);
        $graphQlApi    = Mockery::mock(GraphQL::class);

        $clientFactory->shouldReceive('createAppAndUserAuthenticatedClient')->andReturn($client);
        $client->shouldReceive('graphql')->andReturn($graphQlApi);
        $graphQlApi->shouldReceive('execute')->andReturn($inputData);

        $api = new BranchApi($clientFactory, BranchFactoryTest::instance());

        $data = $api->getBranches($repoFullName, $installationId, $userId);

        self::assertNotEmpty($data);
        self::assertContainsOnlyInstancesOf(GitHubBranch::class, $data);
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
            file_get_contents(__DIR__.'/../../V3/TestData/'.$username.'/installations.json'), true
        );

        foreach ($installations['installations'] as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode(
                file_get_contents(__DIR__.'/../../V3/TestData/'.$vendorName.'/installation-repositories.json'),
                true
            );

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                $data = json_decode(
                    file_get_contents(__DIR__.'/../../V4/TestData/'.$repository['full_name'].'/branches.json'),
                    true
                );

                yield[$installationId, $userId, $repoFullName, $data];
            }
        }
    }

    public function testFetch()
    {
        $appId          = getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');
        $userId         = getenv('GITHUB_TEST_USER_ID');
        $username       = getenv('GITHUB_TEST_USERNAME');
        $token          = getenv('GITHUB_TEST_TOKEN');

        if (false === $appId) {
            self::markTestSkipped('No AppId');
        }
        if (false === $privateKeyPath) {
            self::markTestSkipped('No PrivateKeyPath');
        }
        if (false === $userId) {
            self::markTestSkipped('No user id');
        }
        if (false === $username) {
            self::markTestSkipped('No username');
        }
        if (false === $token) {
            self::markTestSkipped('No token');
        }
        $path = 'file://'.__DIR__.'/../../../'.$privateKeyPath;

        $clientFactory = new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path));

        $api = new BranchApi($clientFactory, BranchFactoryTest::instance());

        $repoFullName = RepoFullName::createFromString('devboard/git-interfaces');
        $data         = $api->getBranches($repoFullName, new InstallationId(125958), new UserId((int) $userId));

        self::assertNotNull($data);
    }
}
