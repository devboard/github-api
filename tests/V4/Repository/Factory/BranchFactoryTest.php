<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHub\GitHubBranch;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\V4\Repository\Factory\BranchFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\Commit\CommitAuthorFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\Commit\CommitCommitterFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\CommitFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Repository\Factory\BranchFactory
 * @group  unit
 */
class BranchFactoryTest extends TestCase
{
    /** @var BranchFactory */
    private $sut;

    public function setUp()
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testBranchFactory(array $data)
    {
        $repoFullName = RepoFullName::createFromString('aaa/todo');

        $sender = $this->sut->createFromBranchData($repoFullName, $data);

        self::assertInstanceOf(GitHubBranch::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4BranchData() as $item) {
            foreach ($item['data']['repository']['refs']['edges'] as $edge) {
                yield[$edge['node']];
            }
        }
    }

    public static function instance(): BranchFactory
    {
        return new BranchFactory(new CommitFactory(new CommitCommitterFactory(), new CommitAuthorFactory()));
    }
}
