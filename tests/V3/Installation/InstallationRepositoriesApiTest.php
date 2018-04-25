<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHub\GitHubRepo;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\InstallationRepositoriesApi;
use Github\Api\Apps;
use Github\Client;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Tests\DevboardLib\GitHubApi\V3\Installation\Factory\GitHubRepoFactoryTest;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\InstallationRepositoriesApi
 */
class InstallationRepositoriesApiTest extends TestCase
{
    /**
     * @group live
     */
    public function testInstallationFactoryLive()
    {
        $appId          = getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');
        $userId         = getenv('GITHUB_TEST_USER_ID');

        if (false === $appId) {
            self::markTestSkipped('No AppId');
        }
        if (false === $privateKeyPath) {
            self::markTestSkipped('No PrivateKeyPath');
        }
        if (false === $userId) {
            self::markTestSkipped('No user id');
        }
        $path = 'file://'.__DIR__.'/../../../'.$privateKeyPath;

        $api = new InstallationRepositoriesApi(
            new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path)), GitHubRepoFactoryTest::instance()
        );

        $results = $api->fetch(new InstallationId(125958), new UserId((int) $userId));

        self::assertCount(30, $results);
        self::assertContainsOnlyInstancesOf(GitHubRepo::class, $results);
    }

    /**
     * @group unit2
     * @dataProvider provideInstallationRepositoriesData
     */
    public function testInstallationFactory($data)
    {
        $installationId = Mockery::mock(InstallationId::class);
        $userId         = Mockery::mock(UserId::class);
        $clientFactory  = Mockery::mock(GitHubClientFactory::class);
        $client         = Mockery::mock(Client::class);
        $appsApi        = Mockery::mock(Apps::class);

        $clientFactory->shouldReceive('createAppAndUserAuthenticatedClient')->andReturn($client);
        $client->shouldReceive('apps')->andReturn($appsApi);
        $appsApi->shouldReceive('listRepositories')->andReturn($data);

        $api = new InstallationRepositoriesApi($clientFactory, GitHubRepoFactoryTest::instance());

        $results = $api->fetch($installationId, $userId);

        self::assertGreaterThan(1, count($results));
        self::assertContainsOnlyInstancesOf(GitHubRepo::class, $results);
    }

    public function provideInstallationRepositoriesData()
    {
        $finder = new Finder();

        $files = $finder->files()->in(__DIR__.'/../TestData/')->name('installation-repositories.json')->getIterator();

        foreach ($files as $file) {
            yield [json_decode($file->getContents(), true)];
        }
    }
}
