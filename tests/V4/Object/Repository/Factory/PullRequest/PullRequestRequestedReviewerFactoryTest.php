<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\PullRequest\PullRequestRequestedReviewer;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestRequestedReviewerFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestRequestedReviewerFactory
 * @group  unit
 */
class PullRequestRequestedReviewerFactoryTest extends TestCase
{
    /** @var PullRequestRequestedReviewerFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestRequestedReviewerFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(PullRequestRequestedReviewer::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    foreach ($edge['node']['reviewRequests']['edges'] as $item) {
                        yield[$item['node']['requestedReviewer']];
                    }
                }
            }
        }
    }

    public static function instance(): PullRequestRequestedReviewerFactory
    {
        return new PullRequestRequestedReviewerFactory();
    }
}
