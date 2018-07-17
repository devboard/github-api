<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\Auth\GitHubApp;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder
 * @group  unit
 */
class JwtTokenBuilderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var int */
    private $gitHubAppId;

    /** @var string */
    private $privateKeyPath;

    /** @var JwtTokenBuilder */
    private $builder;

    public function setUp(): void
    {
        $this->gitHubAppId    = 1;
        $this->privateKeyPath = 'file://'.__DIR__.'/dummy-private-key.pem';
        $this->builder        = new JwtTokenBuilder($this->gitHubAppId, $this->privateKeyPath);
    }

    public function testCreate(): void
    {
        self::assertInstanceOf(JwtTokenAuth::class, $this->builder->create());
    }
}
