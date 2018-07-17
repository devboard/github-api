<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\Installation\Factory\Installation;

use DevboardLib\GitHub\Installation\InstallationAccount;
use DevboardLib\GitHubApi\V3\Installation\Factory\Installation\InstallationAccountFactory;
use PHPUnit\Framework\TestCase;
use Tests\DevboardLib\GitHubApi\V3\TestData\TestDataProvider;

/**
 * @covers \DevboardLib\GitHubApi\V3\Installation\Factory\Installation\InstallationAccountFactory
 * @group  unit
 */
class InstallationAccountFactoryTest extends TestCase
{
    private $sut;

    public function setUp(): void
    {
        $this->sut = new InstallationAccountFactory();
    }

    /** @dataProvider provideData */
    public function testInstallationAccountFactory(array $data): void
    {
        $sender = $this->sut->create($data['account']);

        self::assertInstanceOf(InstallationAccount::class, $sender);
    }

    public function provideData()
    {
        $provider = new TestDataProvider();

        return $provider->getGitHubInstallationData();
    }
}
