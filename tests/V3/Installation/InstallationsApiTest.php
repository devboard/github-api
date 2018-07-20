<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\InstallationsApi;
use Generator;
use Github\Api\CurrentUser;
use Github\Client;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\InstallationsApi
 */
class InstallationsApiTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @group live
     */
    public function testAllUserInstallationsLive(): void
    {
        $token = getenv('GITHUB_TEST_TOKEN');

        if (false === $token) {
            self::markTestSkipped('No token');
        }

        $api = new InstallationsApi(new GitHubClientFactory(Mockery::mock(JwtTokenBuilder::class)));

        $results = $api->allUserInstallations(new JwtTokenAuth($token));

        self::assertCount(3, $results);
    }

    /**
     * @group        unit
     * @dataProvider provideInstallationsData
     */
    public function testAllUserInstallations(array $data): void
    {
        $token          = new JwtTokenAuth('123');
        $clientFactory  = Mockery::mock(GitHubClientFactory::class);
        $client         = Mockery::mock(Client::class);
        $currentUserApi = Mockery::mock(CurrentUser::class);

        $clientFactory->shouldReceive('createAuthenticatedClient')->andReturn($client);
        $client->shouldReceive('currentUser')->andReturn($currentUserApi);
        $currentUserApi->shouldReceive('installations')->andReturn($data);

        $api = new InstallationsApi($clientFactory);

        $results = $api->allUserInstallations($token);

        self::assertCount(3, $results);
    }

    public function provideInstallationsData(): Generator
    {
        $content = file_get_contents(__DIR__.'/../TestData/devboard-test/installations.json');
        yield [json_decode($content, true)];
    }
}
