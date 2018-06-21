<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\GitHubRepoFactory;

/**
 * @see InstallationRepositoriesApiSpec
 * @see InstallationRepositoriesApiTest
 */
class InstallationRepositoriesApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    /** @var GitHubRepoFactory */
    private $gitHubRepoFactory;

    public function __construct(GitHubClientFactory $clientFactory, GitHubRepoFactory $gitHubRepoFactory)
    {
        $this->clientFactory     = $clientFactory;
        $this->gitHubRepoFactory = $gitHubRepoFactory;
    }

    public function allInstallationRepositories(InstallationCredentials $credentials): array
    {
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($credentials);

        $data = $client->apps()->listRepositories();

        return $data['repositories'];
    }

    /**
     * @deprecated Remove this in version 2.0 (together with GitHubRepoFactory)
     */
    public function fetch(InstallationCredentials $credentials)
    {
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($credentials);

        $data = $client->apps()->listRepositories();

        $repos = [];

        foreach ($data['repositories'] as $item) {
            $repos[] = $this->gitHubRepoFactory->create($item);
        }

        return $repos;
    }
}
