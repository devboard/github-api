<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\Auth;

use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DevboardLib\GitHubApi\Auth\JwtTokenAuth
 * @group  unit
 */
class JwtTokenAuthTest extends TestCase
{
    /** @var string */
    private $token;

    /** @var JwtTokenAuth */
    private $jwtTokenAuth;

    public function setUp()
    {
        $this->token        = 'token';
        $this->jwtTokenAuth = new JwtTokenAuth($this->token);
    }

    public function testGetTokenOrLogin()
    {
        self::assertEquals($this->token, $this->jwtTokenAuth->getTokenOrLogin());
    }

    public function testGetToken()
    {
        self::assertEquals($this->token, $this->jwtTokenAuth->getToken());
    }

    public function testGetLogin()
    {
        self::assertNull($this->jwtTokenAuth->getLogin());
    }

    public function testGetPassword()
    {
        self::assertNull($this->jwtTokenAuth->getPassword());
    }

    public function testGetAuthMethod()
    {
        self::assertEquals('jwt', $this->jwtTokenAuth->getAuthMethod());
    }

    public function testSerialize()
    {
        self::assertEquals($this->token, $this->jwtTokenAuth->serialize());
    }

    public function testDeserialize()
    {
        self::assertEquals($this->jwtTokenAuth, JwtTokenAuth::deserialize($this->token));
    }
}
