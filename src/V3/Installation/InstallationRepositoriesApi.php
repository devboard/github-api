<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;
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

    public function fetch(InstallationId $installationId, UserId $githubUserId)
    {
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($installationId, $githubUserId);

        $data = $client->apps()->listRepositories();

        $repos = [];

        foreach ($data['repositories'] as $item) {
            $repos[] = $this->gitHubRepoFactory->create($item);
        }

        return $repos;
    }
}
