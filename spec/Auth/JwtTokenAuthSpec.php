<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Auth;

use DevboardLib\GitHubApi\Auth\AuthMethod;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use PhpSpec\ObjectBehavior;

class JwtTokenAuthSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($token = 'a1b2c3d4-fake-jwt-github-token');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(JwtTokenAuth::class);
        $this->shouldImplement(AuthMethod::class);
    }

    public function it_returns_token_when_asked_for_token_or_login()
    {
        $this->getTokenOrLogin()->shouldReturn('a1b2c3d4-fake-jwt-github-token');
    }

    public function it_returns_token()
    {
        $this->getToken()->shouldReturn('a1b2c3d4-fake-jwt-github-token');
    }

    public function it_returns_null_as_jwt_has_no_login()
    {
        $this->getLogin()->shouldReturn(null);
    }

    public function it_returns_null_as_jwt_has_no_password()
    {
        $this->getPassword()->shouldReturn(null);
    }

    public function it_returns_auth_method()
    {
        $this->getAuthMethod()->shouldReturn('jwt');
    }

    public function it_can_be_serialized()
    {
        $this->serialize()->shouldReturn('a1b2c3d4-fake-jwt-github-token');
    }

    public function it_can_be_deserialized()
    {
        $this->deserialize('a1b2c3d4-fake-jwt-github-token')
            ->shouldReturnAnInstanceOf(JwtTokenAuth::class);
    }
}
