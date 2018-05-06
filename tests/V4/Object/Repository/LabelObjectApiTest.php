<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\AllLabelsQuery;
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
    public function testGetLabels(AllLabelsQuery $query, $inputData)
    {
        $api = Mockery::mock(LabelApi::class);
        $api->shouldReceive('getLabels')->andReturn($inputData);

        $api = new LabelObjectApi($api, LabelFactoryTest::instance());

        $data = $api->getLabels($query);

        self::assertNotEmpty($data);
        self::assertContainsOnlyInstancesOf(GitHubLabel::class, $data);
    }

    public function provideData()
    {
        $provider     = new TestDataProvider();
        $repoFullName = RepoFullName::createFromString('who/cares');
        $credentials  = Mockery::mock(InstallationCredentials::class);
        $query        = new AllLabelsQuery($repoFullName, $credentials);

        foreach ($provider->getGitHubV4LabelData() as $data) {
            yield[$query, $data];
        }
    }
}
