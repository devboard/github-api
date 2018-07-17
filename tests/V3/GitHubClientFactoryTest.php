<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use Github\Client;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubApi\V3\GitHubClientFactory
 * @group  unit
 */
class GitHubClientFactoryTest extends TestCase
{
    /** @var GitHubClientFactory */
    private $sut;

    /** @var MockInterface|JwtTokenBuilder */
    private $jwtTokenBuilder;

    public function setUp(): void
    {
        $this->jwtTokenBuilder = Mockery::mock(JwtTokenBuilder::class);
        $this->sut             = new GitHubClientFactory($this->jwtTokenBuilder);
    }

    public function testCreate(): void
    {
        $result = $this->sut->create();

        self::assertInstanceOf(Client::class, $result);
    }

    public function testCreateAuthenticatedClient(): void
    {
        $authMethod = new JwtTokenAuth('123');

        $result = $this->sut->createAuthenticatedClient($authMethod);

        self::assertInstanceOf(Client::class, $result);
    }

    public function testCreateAppAuthenticatedClient(): void
    {
        $authMethod = new JwtTokenAuth('123');
        $this->jwtTokenBuilder->shouldReceive('create')->andReturn($authMethod);

        $result = $this->sut->createAppAuthenticatedClient();

        self::assertInstanceOf(Client::class, $result);
    }
}
