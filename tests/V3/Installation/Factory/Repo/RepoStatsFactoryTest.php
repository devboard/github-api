<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoStats;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoStatsFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoStatsFactory
 * @group  unit
 */
class RepoStatsFactoryTest extends TestCase
{
    /** @dataProvider provideData */
    public function testFactoryReturnsGitHubRepoStatsInstance(array $data): void
    {
        $sut = new RepoStatsFactory();

        self::assertInstanceOf(RepoStats::class, $sut->create($data));
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        return $provider->getGitHubInstallationRepositoriesData();
    }
}
