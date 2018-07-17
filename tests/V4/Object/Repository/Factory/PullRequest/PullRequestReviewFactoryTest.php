<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\GitHubPullRequestReview;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewFactory
 * @group  unit
 */
class PullRequestReviewFactoryTest extends TestCase
{
    /** @var PullRequestReviewFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestReviewFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubPullRequestReview::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    foreach ($edge['node']['reviews']['edges'] as $item) {
                        yield[$item['node']];
                    }
                }
            }
        }
    }

    public static function instance(): PullRequestReviewFactory
    {
        return new PullRequestReviewFactory();
    }
}
