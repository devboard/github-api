<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoEndpoints;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoEndpointsFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoEndpointsFactory
 * @group  unit
 */
class RepoEndpointsFactoryTest extends TestCase
{
    /** @dataProvider provideData */
    public function testFactoryReturnsGitHubRepoEndpointsInstance(array $data): void
    {
        $sut = new RepoEndpointsFactory();

        $this->assertInstanceOf(RepoEndpoints::class, $sut->create($data));
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        return $provider->getGitHubInstallationRepositoriesData();
    }
}
