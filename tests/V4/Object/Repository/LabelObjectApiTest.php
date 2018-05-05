<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Object\Repository\LabelObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\LabelObjectApi
 */
class LabelObjectApiTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testGetLabels(
        InstallationId $installationId, UserId $userId, RepoFullName $repoFullName, $inputData
    ) {
        $api = Mockery::mock(LabelApi::class);
        $api->shouldReceive('getLabels')->andReturn($inputData);

        $api = new LabelObjectApi($api, LabelFactoryTest::instance());

        $data = $api->getLabels($repoFullName, $installationId, $userId);

        self::assertNotEmpty($data);
        self::assertContainsOnlyInstancesOf(GitHubLabel::class, $data);
    }

    public function provideData()
    {
        $provider       = new TestDataProvider();
        $repoFullName   = RepoFullName::createFromString('who/cares');
        $installationId = new InstallationId(12345666);
        $userId         = new UserId(123);

        foreach ($provider->getGitHubV4LabelData() as $data) {
            yield[$installationId, $userId, $repoFullName, $data];
        }
    }
}
