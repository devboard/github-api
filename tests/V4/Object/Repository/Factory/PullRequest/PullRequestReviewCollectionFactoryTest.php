<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\GitHubPullRequestReviewCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewCollectionFactory
 * @group  unit
 */
class PullRequestReviewCollectionFactoryTest extends TestCase
{
    /** @var PullRequestReviewCollectionFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestReviewCollectionFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubPullRequestReviewCollection::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    yield[$edge['node']['reviews']['edges']];
                }
            }
        }
    }

    public static function instance(): PullRequestReviewCollectionFactory
    {
        return new PullRequestReviewCollectionFactory(new PullRequestReviewFactory());
    }
}
