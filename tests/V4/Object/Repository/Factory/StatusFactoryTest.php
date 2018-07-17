<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubStatus;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status\ExternalServiceFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status\StatusCreatorFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactory
 * @group  unit
 */
class StatusFactoryTest extends TestCase
{
    /** @var StatusFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testStatusFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubStatus::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4BranchStatusData() as $item) {
            foreach ($item['data']['repository']['refs']['edges'] as $edge) {
                if (null !== $edge['node']['target']['status']) {
                    foreach ($edge['node']['target']['status']['contexts'] as $context) {
                        yield[$context];
                    }
                }
            }
        }
    }

    public static function instance(): StatusFactory
    {
        return new StatusFactory(new StatusCreatorFactory(), new ExternalServiceFactory());
    }
}
