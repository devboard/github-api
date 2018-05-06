<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestDetailedResponseFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestDetailedResponse;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeCollectionFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestRequestedReviewerCollectionFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestReviewCollectionFactoryTest;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestDetailedResponseFactory
 * @group  unit
 */
class PullRequestDetailedResponseFactoryTest extends TestCase
{
    /** @var PullRequestDetailedResponseFactory */
    private $sut;

    public function setUp()
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestDetailedResponseFactory(array $data)
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(PullRequestDetailedResponse::class, $sender);
    }

    public function provideData()
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

    public static function instance(): PullRequestDetailedResponseFactory
    {
        return new PullRequestDetailedResponseFactory(
            PullRequestFactoryTest::instance(),
            PullRequestAssigneeCollectionFactoryTest::instance(),
            PullRequestRequestedReviewerCollectionFactoryTest::instance(),
            PullRequestReviewCollectionFactoryTest::instance(),
            LabelCollectionFactoryTest::instance(),
            new MilestoneFactory()
        );
    }
}
