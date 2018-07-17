<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubCommit;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitAuthorFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitCommitterFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\CommitFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\CommitFactory
 * @group  unit
 */
class CommitFactoryTest extends TestCase
{
    /** @var CommitFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testCommitFactory(array $data): void
    {
        $sender = $this->sut->createFromBranchData($data);

        self::assertInstanceOf(GitHubCommit::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4BranchData() as $item) {
            foreach ($item['data']['repository']['refs']['edges'] as $edge) {
                yield[$edge['node']['target']];
            }
        }
    }

    public static function instance(): CommitFactory
    {
        return new CommitFactory(new CommitCommitterFactory(), new CommitAuthorFactory());
    }
}
