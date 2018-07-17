<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactory
 * @group  unit
 */
class MilestoneFactoryTest extends TestCase
{
    /** @var MilestoneFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testMilestoneFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubMilestone::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4MilestoneData() as $item) {
            foreach ($item['data']['repository']['milestones']['edges'] as $edge) {
                yield[$edge['node']];
            }
        }
    }

    public static function instance(): MilestoneFactory
    {
        return new MilestoneFactory();
    }
}
