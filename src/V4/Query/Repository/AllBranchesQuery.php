<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Query\Repository;

use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\Repo\RepoName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;

class AllBranchesQuery implements RepositoryQuery
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var InstallationCredentials */
    private $installationCredentials;

    public function __construct(RepoFullName $repoFullName, InstallationCredentials $installationCredentials)
    {
        $this->repoFullName            = $repoFullName;
        $this->installationCredentials = $installationCredentials;
    }

    public static function create(string $fullName, int $installationId, ?int $userId): self
    {
        return new self(
            RepoFullName::createFromString($fullName), InstallationCredentials::create($installationId, $userId)
        );
    }

    public function getOwnerName(): AccountLogin
    {
        return $this->repoFullName->getOwner();
    }

    public function getRepoName(): RepoName
    {
        return $this->repoFullName->getRepoName();
    }

    public function getCredentials(): InstallationCredentials
    {
        return $this->installationCredentials;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }
}
