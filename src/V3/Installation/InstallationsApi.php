<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Auth\AuthMethod;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\InstallationFactory;

/**
 * @see InstallationsApiSpec
 * @see InstallationsApiTest
 */
class InstallationsApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    /** @var InstallationFactory */
    private $installationFactory;

    public function __construct(GitHubClientFactory $clientFactory, InstallationFactory $installationFactory)
    {
        $this->clientFactory       = $clientFactory;
        $this->installationFactory = $installationFactory;
    }

    public function allUserInstallations(AuthMethod $authMethod): array
    {
        $client = $this->clientFactory->createAuthenticatedClient($authMethod);

        $data = $client->currentUser()->installations();

        return $data['installations'];
    }

    public function fetch(AuthMethod $authMethod): array
    {
        $client = $this->clientFactory->createAuthenticatedClient($authMethod);

        $data = $client->currentUser()->installations();

        $installations = [];

        foreach ($data['installations'] as $installationData) {
            $installations[] = $this->installationFactory->create($installationData);
        }

        return $installations;
    }
}
