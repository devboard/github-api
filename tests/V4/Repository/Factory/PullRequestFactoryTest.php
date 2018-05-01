<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHubApi\V4\Repository\Factory\LabelFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\MilestoneFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\PullRequest\PullRequestAssigneeFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\PullRequest\PullRequestAuthorFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\PullRequestFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Repository\Factory\PullRequestFactory
 * @group  unit
 */
class PullRequestFactoryTest extends TestCase
{
    /** @var PullRequestFactory */
    private $sut;

    public function setUp()
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestFactory(array $data)
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubPullRequest::class, $sender);
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

    public static function instance(): PullRequestFactory
    {
        return new PullRequestFactory(
            new PullRequestAuthorFactory(),
            new PullRequestAssigneeFactory(),
            new MilestoneFactory(),
            new LabelFactory()
        );
    }
}
