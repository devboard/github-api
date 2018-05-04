<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation\Factory;

use DevboardLib\GitHub\Application\ApplicationId;
use DevboardLib\GitHub\GitHubInstallation;
use DevboardLib\GitHub\Installation\InstallationAccessTokenUrl;
use DevboardLib\GitHub\Installation\InstallationCreatedAt;
use DevboardLib\GitHub\Installation\InstallationEvents;
use DevboardLib\GitHub\Installation\InstallationHtmlUrl;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Installation\InstallationPermissions;
use DevboardLib\GitHub\Installation\InstallationRepositoriesUrl;
use DevboardLib\GitHub\Installation\InstallationRepositorySelectionFactory;
use DevboardLib\GitHub\Installation\InstallationUpdatedAt;
use DevboardLib\GitHubApi\V3\Installation\Factory\Installation\InstallationAccountFactory;
use Throwable;

/**
 * @see InstallationFactorySpec
 * @see InstallationFactoryTest
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InstallationFactory
{
    /** @var InstallationAccountFactory */
    private $installationAccountFactory;

    public function __construct(InstallationAccountFactory $installationAccountFactory)
    {
        $this->installationAccountFactory = $installationAccountFactory;
    }

    public function create(array $data): GitHubInstallation
    {
        $account = $this->installationAccountFactory->create($data['account']);

        try {
            $createdAt = InstallationCreatedAt::createFromFormat('U', (string) $data['created_at']);
        } catch (Throwable $exception) {
            $createdAt = new InstallationCreatedAt($data['updated_at']);
        }

        try {
            $updatedAt = InstallationUpdatedAt::createFromFormat('U', (string) $data['updated_at']);
        } catch (Throwable $exception) {
            $updatedAt = new InstallationUpdatedAt($data['updated_at']);
        }

        return new GitHubInstallation(
            new InstallationId($data['id']),
            $account,
            new ApplicationId($data['app_id']),
            InstallationRepositorySelectionFactory::create($data['repository_selection']),
            new InstallationPermissions($data['permissions']),
            new InstallationEvents($data['events']),
            new InstallationAccessTokenUrl($data['access_tokens_url']),
            new InstallationRepositoriesUrl($data['repositories_url']),
            new InstallationHtmlUrl($data['html_url']),
            $createdAt,
            $updatedAt
        );
    }
}
