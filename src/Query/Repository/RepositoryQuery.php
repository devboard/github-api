<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository;

use DevboardLib\Generix\QueryRequest;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\Repo\RepoName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;

interface RepositoryQuery extends QueryRequest
{
    public function getOwnerName(): AccountLogin;

    public function getRepoName(): RepoName;

    public function getCredentials(): InstallationCredentials;

    public function getRepoFullName(): RepoFullName;
}
