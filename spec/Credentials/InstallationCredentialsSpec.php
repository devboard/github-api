<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Credentials;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\Credentials\Credentials;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use PhpSpec\ObjectBehavior;

class InstallationCredentialsSpec extends ObjectBehavior
{
    public function let(InstallationId $installationId, UserId $userId)
    {
        $this->beConstructedWith($installationId, $userId);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InstallationCredentials::class);
        $this->shouldHaveType(Credentials::class);
    }

    public function it_can_be_constructed_without_user_id(InstallationId $installationId)
    {
        $this->beConstructedWith($installationId);
    }
}
