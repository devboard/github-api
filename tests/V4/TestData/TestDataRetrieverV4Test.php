<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\TestData;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\AllBranchesQuery;
use DevboardLib\GitHubApi\Query\Repository\AllLabelsQuery;
use DevboardLib\GitHubApi\Query\Repository\AllMilestonesQuery;
use DevboardLib\GitHubApi\Query\Repository\AllPullRequestsQuery;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\BranchApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\StatusApi;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @group fetch
 */
class TestDataRetrieverV4Test extends TestCase
{
    /** @var UserId */
    private $userId;

    /** @var string */
    private $username;

    /** @var GitHubClientFactory */
    private $clientFactory;

    public function setUp()
    {
        parent::setUp();

        if (false === getenv('GITHUB_TEST_USER_ID')) {
            self::markTestSkipped('No user id');
        }
        if (false === getenv('GITHUB_TEST_USERNAME')) {
            self::markTestSkipped('No username');
        }
        if (false === getenv('GITHUB_TEST_APP_ID')) {
            self::markTestSkipped('No AppId');
        }
        if (false === getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH')) {
            self::markTestSkipped('No PrivateKeyPath');
        }

        $this->userId   = new UserId((int) getenv('GITHUB_TEST_USER_ID'));
        $this->username = getenv('GITHUB_TEST_USERNAME');

        $this->clientFactory = $this->getClientFactory();
    }

    /** @dataProvider provideRepositoriesData */
    public function testBranchesFetch(InstallationId $installationId, RepoFullName $repoFullName)
    {
        $api = new BranchApi($this->clientFactory);

        $query = new AllBranchesQuery($repoFullName, new InstallationCredentials($installationId, $this->userId));

        $data = $api->getBranches($query);

        self::assertNotEmpty($data);

        $this->writeJson($repoFullName->__toString(), 'branches.json', $data);
    }

    /** @dataProvider provideRepositoriesData */
    public function testLabelsFetch(InstallationId $installationId, RepoFullName $repoFullName)
    {
        $api   = new LabelApi($this->clientFactory);
        $query = new AllLabelsQuery($repoFullName, new InstallationCredentials($installationId, $this->userId));
        $data  = $api->getLabels($query);

        self::assertNotEmpty($data);

        $this->writeJson($repoFullName->__toString(), 'labels.json', $data);
    }

    /** @dataProvider provideRepositoriesData */
    public function testMilestonesFetch(InstallationId $installationId, RepoFullName $repoFullName)
    {
        $api   = new MilestoneApi($this->clientFactory);
        $query = new AllMilestonesQuery($repoFullName, new InstallationCredentials($installationId, $this->userId));
        $data  = $api->getMilestones($query);

        self::assertNotEmpty($data);

        $this->writeJson($repoFullName->__toString(), 'milestones.json', $data);
    }

    /** @dataProvider provideRepositoriesData */
    public function testPullRequestsFetch(InstallationId $installationId, RepoFullName $repoFullName)
    {
        $api = new PullRequestApi($this->clientFactory);

        $query = new AllPullRequestsQuery($repoFullName, new InstallationCredentials($installationId, $this->userId));

        $data = $api->getPullRequests($query);

        self::assertNotEmpty($data);

        $this->writeJson($repoFullName->__toString(), 'pullrequests.json', $data);
    }

    /** @dataProvider provideRepositoriesData */
    public function testStatusBranchesFetch(InstallationId $installationId, RepoFullName $repoFullName)
    {
        $api = new StatusApi($this->clientFactory);

        $data = $api->getBranches($repoFullName, $installationId, $this->userId);

        self::assertNotEmpty($data);

        $this->writeJson($repoFullName->__toString(), 'branch_statuses.json', $data);
    }

    /** @dataProvider provideRepositoriesData */
    public function testStatusPullRequestFetch(InstallationId $installationId, RepoFullName $repoFullName)
    {
        $api = new StatusApi($this->clientFactory);

        $data = $api->getPullRequests($repoFullName, $installationId, $this->userId);

        self::assertNotEmpty($data);

        $this->writeJson($repoFullName->__toString(), 'pullrequest_statuses.json', $data);
    }

    public function provideRepositoriesData(): Generator
    {
        $installations = json_decode($this->getInstallationsFileContent(), true)['installations'];
        self::assertCount(3, $installations);

        foreach ($installations as $installation) {
            $installationId = new InstallationId((int) $installation['id']);
            $vendorName     = $installation['account']['login'];

            $repositories = json_decode($this->getInstallationRepositoriesFileContent($vendorName), true);

            foreach ($repositories['repositories'] as $repository) {
                $repoFullName = RepoFullName::createFromString($repository['full_name']);

                yield [$installationId, $repoFullName];
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
        $appId          = (int) getenv('GITHUB_TEST_APP_ID');
        $privateKeyPath = getenv('GITHUB_TEST_APP_PRIVATE_KEY_PATH');

        $path = 'file://'.__DIR__.'/../../../'.$privateKeyPath;

        return new GitHubClientFactory(new JwtTokenBuilder($appId, $path));
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
