<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHubApi\V4\Repository\Factory\LabelFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V4\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V4\Repository\Factory\LabelFactory
 * @group  unit
 */
class LabelFactoryTest extends TestCase
{
    /** @var LabelFactory */
    private $sut;

    public function setUp()
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testLabelFactory(array $data)
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubLabel::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        foreach ($provider->getGitHubV4LabelData() as $item) {
            foreach ($item['data']['repository']['labels']['edges'] as $edge) {
                yield[$edge['node']];
            }
        }
    }

    public static function instance(): LabelFactory
    {
        return new LabelFactory();
    }
}
