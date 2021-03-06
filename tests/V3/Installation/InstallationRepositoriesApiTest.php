<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\InstallationRepositoriesApi;
use Generator;
use Github\Api\Apps;
use Github\Client;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\InstallationRepositoriesApi
 */
class InstallationRepositoriesApiTest extends TestCase
{
    /**
     * @group live
     */
    public function testAllInstallationRepositoriesLive(): void
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

        $api = new InstallationRepositoriesApi(new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path)));

        $results = $api->allInstallationRepositories(InstallationCredentials::create(125958, (int) $userId));

        self::assertCount(30, $results);
    }

    /**
     * @group        unit
     * @dataProvider provideInstallationRepositoriesData
     */
    public function testAllInstallationRepositories(array $data): void
    {
        $clientFactory = Mockery::mock(GitHubClientFactory::class);
        $client        = Mockery::mock(Client::class);
        $appsApi       = Mockery::mock(Apps::class);

        $clientFactory->shouldReceive('createAppAndUserAuthenticatedClient')->andReturn($client);
        $client->shouldReceive('apps')->andReturn($appsApi);
        $appsApi->shouldReceive('listRepositories')->andReturn($data);

        $api = new InstallationRepositoriesApi($clientFactory);

        $results = $api->allInstallationRepositories(InstallationCredentials::create(125958, 123));

        self::assertGreaterThan(1, count($results));
    }

    public function provideInstallationRepositoriesData(): Generator
    {
        $finder = new Finder();

        $files = $finder->files()->in(__DIR__.'/../TestData/')->name('installation-repositories.json')->getIterator();

        foreach ($files as $file) {
            yield [json_decode($file->getContents(), true)];
        }
    }
}
