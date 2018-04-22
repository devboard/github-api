<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\TestData;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @group fetch
 */
class TestDataRetrieverTest extends TestCase
{
    public function testInstallationFetch()
    {
        $username = getenv('GITHUT_TEST_USERNAME');
        $token    = getenv('GITHUT_TEST_TOKEN');

        if (false === $username) {
            self::markTestSkipped('No username');
        }
        if (false === $token) {
            self::markTestSkipped('No token');
        }

        $clientFactory = new GitHubClientFactory(Mockery::mock(JwtTokenBuilder::class));

        $client = $clientFactory->createAuthenticatedClient(new JwtTokenAuth($token));

        $data = $client->currentUser()->installations();

        self::assertCount(3, $data['installations']);

        $this->writeJson($username, 'installations.json', $data);
    }

    public function testInstallationRepositoriesFetch()
    {
        $appId          = getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');
        $userId         = getenv('GITHUT_TEST_USER_ID');
        $username       = getenv('GITHUT_TEST_USERNAME');

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

        $path = 'file://'.__DIR__.'/../../../'.$privateKeyPath;

        $installationsContent = file_get_contents(__DIR__.'/'.$username.'/installations.json');

        $installations = json_decode($installationsContent, true)['installations'];

        self::assertCount(3, $installations);

        $clientFactory = new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path));

        foreach ($installations as $installation) {
            $client = $clientFactory->createAppAndUserAuthenticatedClient(
                new InstallationId($installation['id']), new UserId((int) $userId)
            );

            $data = $client->apps()->listRepositories();

            $this->writeJson($installation['account']['login'], 'installation-repositories.json', $data);
        }
    }

    private function writeJson(string $vendor, string $filename, $data)
    {
        //BitMask: pretty print and no escaped slashes
        $encodeOptions = JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES;

        $folder = __DIR__.'/'.$vendor.'/';

        if (false === is_dir($folder)) {
            mkdir($folder);
        }
        file_put_contents($folder.$filename, json_encode($data, $encodeOptions));
    }
}
