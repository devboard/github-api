<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation\Factory;

use DevboardLib\GitHub\GitHubInstallation;
use DevboardLib\GitHubApi\V3\Installation\Factory\Installation\InstallationAccountFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\InstallationFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\Factory\InstallationFactory
 * @group  unit
 */
class InstallationFactoryTest extends TestCase
{
    /** @var InstallationFactory */
    private $sut;

    public function setUp(): void
    {
        $this->sut = self::instance();
    }

    /** @dataProvider provideData */
    public function testInstallationFactory(array $data): void
    {
        $sender = $this->sut->create($data);

        self::assertInstanceOf(GitHubInstallation::class, $sender);
    }

    public function provideData(): array
    {
        $provider = new TestDataProvider();

        return $provider->getGitHubInstallationData();
    }

    public static function instance(): InstallationFactory
    {
        return new InstallationFactory(new InstallationAccountFactory());
    }
}
