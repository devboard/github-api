<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\PullRequest\PullRequestAssigneeCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeCollectionFactory
 * @group  unit
 */
class PullRequestAssigneeCollectionFactoryTest extends TestCase
{
    /** @var PullRequestAssigneeCollectionFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestAssigneeCollectionFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(PullRequestAssigneeCollection::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    yield[$edge['node']['assignees']['edges']];
                }
            }
        }
    }

    public static function instance(): PullRequestAssigneeCollectionFactory
    {
        return new PullRequestAssigneeCollectionFactory(new PullRequestAssigneeFactory());
    }
}
