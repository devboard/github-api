<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation\Factory;

use DevboardLib\GitHub\GitHubRepo;
use DevboardLib\GitHubApi\V3\Installation\Factory\GitHubRepoFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoEndpointsFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoOwnerFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoStatsFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoTimestampsFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\Factory\GitHubRepoFactory
 * @group  unit
 */
class GitHubRepoFactoryTest extends TestCase
{
    /** @dataProvider provideData */
    public function testFactoryReturnsGitHubRepoInstance(array $data): void
    {
        $sut = self::instance();

        $this->assertInstanceOf(GitHubRepo::class, $sut->create($data));
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        return $provider->getGitHubInstallationRepositoriesData();
    }

    public static function instance(): GitHubRepoFactory
    {
        return new GitHubRepoFactory(
            new RepoOwnerFactory(), new RepoEndpointsFactory(), new RepoTimestampsFactory(), new RepoStatsFactory()
        );
    }
}
