<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation;

use DevboardLib\GitHubApi\Auth\AuthMethod;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

/**
 * @see InstallationsApiSpec
 * @see InstallationsApiTest
 */
class InstallationsApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function allUserInstallations(AuthMethod $authMethod): array
    {
        $client = $this->clientFactory->createAuthenticatedClient($authMethod);

        $data = $client->currentUser()->installations();

        return $data['installations'];
    }
}
