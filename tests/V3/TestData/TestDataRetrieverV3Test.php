<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\TestData;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @group fetch
 */
class TestDataRetrieverV3Test extends TestCase
{
    public function testInstallationFetch(): void
    {
        $token = getenv('GITHUB_TEST_TOKEN');

        if (false === $token) {
            self::markTestSkipped('No token');
        }

        $clientFactory = new GitHubClientFactory(Mockery::mock(JwtTokenBuilder::class));

        $client = $clientFactory->createAuthenticatedClient(new JwtTokenAuth($token));

        $data = $client->currentUser()->installations();

        self::assertCount(3, $data['installations']);

        $this->writeJson('devboard-test', 'installations.json', $data);
    }

    public function testInstallationRepositoriesFetch(): void
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

        $installations = json_decode($this->getInstallationsFileContent(), true)['installations'];

        self::assertCount(3, $installations);

        $clientFactory = new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path));

        foreach ($installations as $installation) {
            $client = $clientFactory->createAppAndUserAuthenticatedClient(
                InstallationCredentials::create($installation['id'], (int) $userId)
            );

            $data = $client->apps()->listRepositories();

            $this->writeJson($installation['account']['login'], 'installation-repositories.json', $data);
        }
    }

    /** @param mixed $data */
    private function writeJson(string $vendor, string $filename, $data): void
    {
        //BitMask: pretty print and no escaped slashes
        $encodeOptions = JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES;

        $folder = __DIR__.'/'.$vendor.'/';

        if (false === is_dir($folder)) {
            mkdir($folder);
        }
        file_put_contents($folder.$filename, json_encode($data, $encodeOptions));
    }

    private function getInstallationsFileContent(): string
    {
        return file_get_contents(__DIR__.'/devboard-test/installations.json');
    }
}
