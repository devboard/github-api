<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3;

use DevboardLib\GitHubApi\Auth\AuthMethod;
use DevboardLib\GitHubApi\Auth\GitHubApp\JwtTokenBuilder;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use Github\Client;
use Github\HttpClient\Builder;

/**
 * @see GitHubClientFactorySpec
 * @see GitHubClientFactoryTest
 */
class GitHubClientFactory
{
    /** @var JwtTokenBuilder */
    private $jwtTokenBuilder;

    public function __construct(JwtTokenBuilder $jwtTokenBuilder)
    {
        $this->jwtTokenBuilder = $jwtTokenBuilder;
    }

    public function create(): Client
    {
        return new Client(new Builder(), 'machine-man-preview');
    }

    public function createAuthenticatedClient(AuthMethod $authMethod): Client
    {
        $client = $this->create();

        $client->authenticate($authMethod->getTokenOrLogin(), $authMethod->getPassword(), $authMethod->getAuthMethod());

        return $client;
    }

    public function createAppAuthenticatedClient(): Client
    {
        $appToken = $this->jwtTokenBuilder->create();

        return $this->createAuthenticatedClient($appToken);
    }

    public function createAppAndUserAuthenticatedClient(InstallationCredentials $credentials): Client
    {
        $client = $this->createAppAuthenticatedClient();

        $personalToken = $client->apps()
            ->createInstallationToken($credentials->getInstallationIdValue(), $credentials->getUserIdValue());

        $client->authenticate($personalToken['token'], null, Client::AUTH_HTTP_TOKEN);

        return $client;
    }
}
