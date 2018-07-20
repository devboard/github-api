<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

/**
 * @see InstallationRepositoriesApiSpec
 * @see InstallationRepositoriesApiTest
 */
class InstallationRepositoriesApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function allInstallationRepositories(InstallationCredentials $credentials): array
    {
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($credentials);

        $data = $client->apps()->listRepositories();

        return $data['repositories'];
    }
}
