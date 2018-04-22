<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Auth\GitHubApp;

use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use PhpSpec\ObjectBehavior;

class JwtTokenBuilderSpec extends ObjectBehavior
{
    public function let()
    {
        // Dummy key file!
        $this->beConstructedWith($gitHubAppId = 1, $privateKeyPath = 'file://'.__DIR__.'/dummy-private-key.pem');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(JwtTokenBuilder::class);
    }

    public function it_returns_built_token()
    {
        $this->create()->shouldReturnAnInstanceOf(JwtTokenAuth::class);
    }
}
