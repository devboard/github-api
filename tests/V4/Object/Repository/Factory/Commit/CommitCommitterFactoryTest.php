<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit;

use DevboardLib\GitHub\Commit\CommitCommitter;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitCommitterFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitCommitterFactory
 * @group  unit
 */
class CommitCommitterFactoryTest extends TestCase
{
    /** @var CommitCommitterFactory */
    private $sut;

    public function setUp()
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testCommitCommitterFactory(array $data)
    {
        $sender = $this->sut->createFromBranchData($data);

        self::assertInstanceOf(CommitCommitter::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4BranchData() as $item) {
            foreach ($item['data']['repository']['refs']['edges'] as $edge) {
                yield[$edge['node']['target']['committer']];
            }
        }
    }

    public static function instance(): CommitCommitterFactory
    {
        return new CommitCommitterFactory();
    }
}
