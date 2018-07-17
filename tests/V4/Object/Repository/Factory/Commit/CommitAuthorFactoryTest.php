<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit;

use DevboardLib\GitHub\Commit\CommitAuthor;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitAuthorFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitAuthorFactory
 * @group  unit
 */
class CommitAuthorFactoryTest extends TestCase
{
    /** @var CommitAuthorFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testCommitAuthorFactory(array $data): void
    {
        $sender = $this->sut->createFromBranchData($data);

        self::assertInstanceOf(CommitAuthor::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4BranchData() as $item) {
            foreach ($item['data']['repository']['refs']['edges'] as $edge) {
                yield[$edge['node']['target']['author']];
            }
        }
    }

    public static function instance(): CommitAuthorFactory
    {
        return new CommitAuthorFactory();
    }
}
