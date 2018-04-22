<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V3;

use DevboardLib\GitHubApi\Auth\AuthMethod;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use Github\Client;
use PhpSpec\ObjectBehavior;

class GitHubClientFactorySpec extends ObjectBehavior
{
    public function let(JwtTokenBuilder $jwtTokenBuilder)
    {
        $this->beConstructedWith($jwtTokenBuilder);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(GitHubClientFactory::class);
    }

    public function it_will_create_one()
    {
        $this->create()->shouldReturnAnInstanceOf(Client::class);
    }

    public function it_will_create_authenticated_client(AuthMethod $authMethod)
    {
        $authMethod->getTokenOrLogin()
            ->shouldBeCalled()
            ->willReturn('token-or-login');

        $authMethod->getPassword()
            ->shouldBeCalled()
            ->willReturn('password-or-null');

        $authMethod->getAuthMethod()
            ->shouldBeCalled()
            ->willReturn('auth-method-used');

        $this->createAuthenticatedClient($authMethod)->shouldReturnAnInstanceOf(Client::class);
    }

    public function it_will_create_github_app_authenticated_client(
        JwtTokenBuilder $jwtTokenBuilder, JwtTokenAuth $jwtToken
    ) {
        $jwtTokenBuilder->create()
            ->shouldBeCalled()
            ->willReturn($jwtToken);

        $jwtToken->getTokenOrLogin()
            ->shouldBeCalled()
            ->willReturn('jwt-token');

        $jwtToken->getPassword()
            ->shouldBeCalled()
            ->willReturn(null);

        $jwtToken->getAuthMethod()
            ->shouldBeCalled()
            ->willReturn('jwt');

        $this->createAppAuthenticatedClient()->shouldReturnAnInstanceOf(Client::class);
    }
}
