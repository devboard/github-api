<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\PullRequest\PullRequestAuthor;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAuthorFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest\PullRequestAuthorFactory
 * @group  unit
 */
class PullRequestAuthorFactoryTest extends TestCase
{
    /** @var PullRequestAuthorFactory */
    private $sut;

    public function setUp()
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testPullRequestAuthorFactory(array $data)
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(PullRequestAuthor::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    if (null !== $edge['node']['author']) {
                        yield[$edge['node']['author']];
                    }
                }
            }
        }
    }

    public static function instance(): PullRequestAuthorFactory
    {
        return new PullRequestAuthorFactory();
    }
}
