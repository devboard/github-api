<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Auth\AuthMethod;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\InstallationsApi;
use Github\Api\CurrentUser as CurrentUserApi;
use Github\Client;
use PhpSpec\ObjectBehavior;

class InstallationsApiSpec extends ObjectBehavior
{
    public function let(GitHubClientFactory $clientFactory)
    {
        $this->beConstructedWith($clientFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InstallationsApi::class);
    }

    public function it_should_fetch_all_of_the_user_installations(
        AuthMethod $authMethod, GitHubClientFactory $clientFactory, Client $client, CurrentUserApi $currentUserApi
    ) {
        $clientFactory->createAuthenticatedClient($authMethod)
            ->shouldBeCalled()
            ->willReturn($client);

        $client->currentUser()
            ->shouldBeCalled()
            ->willReturn($currentUserApi);

        $currentUserApi->installations()
            ->shouldBeCalled()
            ->willReturn(['installations' => [['installation1-data'], ['installation2-data']]]);

        $this->allUserInstallations($authMethod);
    }
}
