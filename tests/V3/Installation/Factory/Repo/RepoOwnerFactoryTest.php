<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoOwner;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoOwnerFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoOwnerFactory
 * @group  unit
 */
class RepoOwnerFactoryTest extends TestCase
{
    /** @dataProvider provideData */
    public function testFactoryReturnsGitHubRepoStatsInstance(array $data): void
    {
        $sut = new RepoOwnerFactory();

        self::assertInstanceOf(RepoOwner::class, $sut->create($data));
    }

    public function provideData(): array
    {
        $provider = new TestDataProvider();

        return $provider->getGitHubInstallationRepositoriesData();
    }
}
