<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubLabelCollection;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelCollectionFactory
 * @group  unit
 */
class LabelCollectionFactoryTest extends TestCase
{
    /** @var LabelCollectionFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testLabelCollectionFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubLabelCollection::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4PullRequestData() as $data) {
            foreach ($data as $item) {
                foreach ($item['data']['repository']['pullRequests']['edges'] as $edge) {
                    yield[$edge['node']['labels']['edges']];
                }
            }
        }
    }

    public static function instance(): LabelCollectionFactory
    {
        return new LabelCollectionFactory(new LabelFactory());
    }
}
