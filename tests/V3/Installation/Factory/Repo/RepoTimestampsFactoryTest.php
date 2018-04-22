<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoTimestamps;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoTimestampsFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoTimestampsFactory
 * @group  unit
 */
class RepoTimestampsFactoryTest extends TestCase
{
    /** @dataProvider provideData */
    public function testFactoryReturnsRepoTimestampsInstance(array $data)
    {
        $sut = new RepoTimestampsFactory();

        $this->assertInstanceOf(RepoTimestamps::class, $sut->create($data));
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        return $provider->getGitHubInstallationRepositoriesData();
    }
}
