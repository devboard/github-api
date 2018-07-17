<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\PullRequest\PullRequestAssignee;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAssigneeFactory
 * @group  unit
 */
class PullRequestAssigneeFactoryTest extends TestCase
{
    /** @var PullRequestAssigneeFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestAssigneeFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(PullRequestAssignee::class, $sender);
    }

    public function provideData(): Generator
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    foreach ($edge['node']['assignees']['edges'] as $item) {
                        yield[$item['node']];
                    }
                }
            }
        }
    }

    public static function instance(): PullRequestAssigneeFactory
    {
        return new PullRequestAssigneeFactory();
    }
}
