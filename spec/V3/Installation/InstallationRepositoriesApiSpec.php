<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\GitHubRepoFactory;
use DevboardLib\GitHubApi\V3\Installation\InstallationRepositoriesApi;
use Github\Api\Apps as AppsApi;
use Github\Client;
use PhpSpec\ObjectBehavior;

class InstallationRepositoriesApiSpec extends ObjectBehavior
{
    public function let(GitHubClientFactory $clientFactory, GitHubRepoFactory $gitHubRepoFactory)
    {
        $this->beConstructedWith($clientFactory, $gitHubRepoFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InstallationRepositoriesApi::class);
    }

    public function it_retrieves_installation_repositories_accessible_by_user(
        InstallationCredentials $credentials, GitHubClientFactory $clientFactory, Client $client, AppsApi $appsApi
    ) {
        $clientFactory->createAppAndUserAuthenticatedClient($credentials)
            ->shouldBeCalled()
            ->willReturn($client);

        $client->apps()
            ->shouldBeCalled()
            ->willReturn($appsApi);

        $appsApi->listRepositories()
            ->shouldBeCalled()
            ->willReturn(['repositories' => []]);

        $this->fetch($credentials);
    }
}
