<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\TestData;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @group fetch
 */
class TestDataRetrieverV4Test extends TestCase
{
    public function testBranchesFetch()
    {
        $userId   = getenv('GITHUB_TEST_USER_ID');
        $username = getenv('GITHUB_TEST_USERNAME');

        if (false === $userId) {
            self::markTestSkipped('No user id');
        }

        if (false === $username) {
            self::markTestSkipped('No username');
        }

        $clientFactory = $this->getClientFactory();

        $api = new BranchApi($clientFactory);

        $installations = json_decode($this->getInstallationsFileContent(), true)['installations'];

        self::assertCount(3, $installations);

        foreach ($installations as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode($this->getInstallationRepositoriesFileContent($vendorName), true);

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                $data = $api->getBranches($repoFullName, $installationId, new UserId((int) $userId));

                $this->writeJson($repository['full_name'], 'branches.json', $data);
            }
        }
    }

    public function testLabelsFetch()
    {
        $userId   = getenv('GITHUB_TEST_USER_ID');
        $username = getenv('GITHUB_TEST_USERNAME');

        if (false === $userId) {
            self::markTestSkipped('No user id');
        }

        if (false === $username) {
            self::markTestSkipped('No username');
        }

        $clientFactory = $this->getClientFactory();

        $api = new LabelApi($clientFactory);

        $installations = json_decode($this->getInstallationsFileContent(), true)['installations'];

        self::assertCount(3, $installations);

        foreach ($installations as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode($this->getInstallationRepositoriesFileContent($vendorName), true);

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                $data = $api->getLabels($repoFullName, $installationId, new UserId((int) $userId));

                $this->writeJson($repository['full_name'], 'labels.json', $data);
            }
        }
    }

    public function testMilestonesFetch()
    {
        $userId   = getenv('GITHUB_TEST_USER_ID');
        $username = getenv('GITHUB_TEST_USERNAME');

        if (false === $userId) {
            self::markTestSkipped('No user id');
        }

        if (false === $username) {
            self::markTestSkipped('No username');
        }

        $clientFactory = $this->getClientFactory();

        $api = new MilestoneApi($clientFactory);

        $installations = json_decode($this->getInstallationsFileContent(), true)['installations'];

        self::assertCount(3, $installations);

        foreach ($installations as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode($this->getInstallationRepositoriesFileContent($vendorName), true);

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                $data = $api->getMilestones($repoFullName, $installationId, new UserId((int) $userId));

                $this->writeJson($repository['full_name'], 'milestones.json', $data);
            }
        }
    }

    /**
     * @group wip2
     */
    public function testPullRequestsFetch()
    {
        $userId   = getenv('GITHUB_TEST_USER_ID');
        $username = getenv('GITHUB_TEST_USERNAME');

        if (false === $userId) {
            self::markTestSkipped('No user id');
        }

        if (false === $username) {
            self::markTestSkipped('No username');
        }

        $clientFactory = $this->getClientFactory();

        $api = new PullRequestApi($clientFactory);

        $installations = json_decode($this->getInstallationsFileContent(), true)['installations'];

        self::assertCount(3, $installations);

        foreach ($installations as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode($this->getInstallationRepositoriesFileContent($vendorName), true);

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                $data = $api->getPullRequests($repoFullName, $installationId, new UserId((int) $userId));

                $this->writeJson($repository['full_name'], 'pullrequests.json', $data);
            }
        }
    }

    private function writeJson(string $vendor, string $filename, $data)
    {
        //BitMask: pretty print and no escaped slashes
        $encodeOptions = JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES;

        $folder = __DIR__.'/'.$vendor.'/';

        if (false === is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        file_put_contents($folder.$filename, json_encode($data, $encodeOptions));
    }

    private function getClientFactory(): GitHubClientFactory
    {
        $appId          = getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');

        if (false === $appId) {
            self::markTestSkipped('No AppId');
        }
        if (false === $privateKeyPath) {
            self::markTestSkipped('No PrivateKeyPath');
        }

        $path = 'file://'.__DIR__.'/../../../'.$privateKeyPath;

        $clientFactory = new GitHubClientFactory(new JwtTokenBuilder((int) $appId, $path));

        return $clientFactory;
    }

    private function getInstallationsFileContent(): string
    {
        return file_get_contents(__DIR__.'/../../V3/TestData/devboard-test/installations.json');
    }

    private function getInstallationRepositoriesFileContent(string $vendorName): string
    {
        return file_get_contents(__DIR__.'/../../V3/TestData/'.$vendorName.'/installation-repositories.json');
    }
}
