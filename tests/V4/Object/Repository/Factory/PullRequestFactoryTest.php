<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAuthorFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactory
 * @group  unit
 */
class PullRequestFactoryTest extends TestCase
{
    /** @var PullRequestFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubPullRequest::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    yield[$edge['node']];
                }
            }
        }
    }

    public static function instance(): PullRequestFactory
    {
        return new PullRequestFactory(new PullRequestAuthorFactory());
    }
}
