<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHub\GitHubInstallation;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\InstallationsApi;
use Github\Api\CurrentUser;
use Github\Client;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\Installation\Factory\InstallationFactoryTest;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\InstallationsApi
 */
class InstallationsApiTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @group live
     */
    public function testAllUserInstallationsLive()
    {
        $token = getenv('GITHUB_TEST_TOKEN');

        if (false === $token) {
            self::markTestSkipped('No token');
        }

        $api = new InstallationsApi(
            new GitHubClientFactory(Mockery::mock(JwtTokenBuilder::class)), InstallationFactoryTest::instance()
        );

        $results = $api->allUserInstallations(new JwtTokenAuth($token));

        self::assertCount(3, $results);
    }

    /**
     * @group        unit
     * @dataProvider provideInstallationsData
     */
    public function testAllUserInstallations($data)
    {
        $token          = new JwtTokenAuth('123');
        $clientFactory  = Mockery::mock(GitHubClientFactory::class);
        $client         = Mockery::mock(Client::class);
        $currentUserApi = Mockery::mock(CurrentUser::class);

        $clientFactory->shouldReceive('createAuthenticatedClient')->andReturn($client);
        $client->shouldReceive('currentUser')->andReturn($currentUserApi);
        $currentUserApi->shouldReceive('installations')->andReturn($data);

        $api = new InstallationsApi($clientFactory, InstallationFactoryTest::instance());

        $results = $api->allUserInstallations($token);

        self::assertCount(3, $results);
    }

    /**
     * @group live
     */
    public function testInstallationFactoryLive()
    {
        $token = getenv('GITHUB_TEST_TOKEN');

        if (false === $token) {
            self::markTestSkipped('No token');
        }

        $api = new InstallationsApi(
            new GitHubClientFactory(Mockery::mock(JwtTokenBuilder::class)), InstallationFactoryTest::instance()
        );

        $results = $api->fetch(new JwtTokenAuth($token));

        self::assertCount(3, $results);
        self::assertContainsOnlyInstancesOf(GitHubInstallation::class, $results);
    }

    /**
     * @group        unit
     * @dataProvider provideInstallationsData
     */
    public function testInstallationFactory($data)
    {
        $token          = new JwtTokenAuth('123');
        $clientFactory  = Mockery::mock(GitHubClientFactory::class);
        $client         = Mockery::mock(Client::class);
        $currentUserApi = Mockery::mock(CurrentUser::class);

        $clientFactory->shouldReceive('createAuthenticatedClient')->andReturn($client);
        $client->shouldReceive('currentUser')->andReturn($currentUserApi);
        $currentUserApi->shouldReceive('installations')->andReturn($data);

        $api = new InstallationsApi($clientFactory, InstallationFactoryTest::instance());

        $results = $api->fetch($token);

        self::assertCount(3, $results);
        self::assertContainsOnlyInstancesOf(GitHubInstallation::class, $results);
    }

    public function provideInstallationsData()
    {
        $content = file_get_contents(__DIR__.'/../TestData/devboard-test/installations.json');
        yield [json_decode($content, true)];
    }
}
