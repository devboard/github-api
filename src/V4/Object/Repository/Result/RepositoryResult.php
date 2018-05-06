<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Result\Result;

interface RepositoryResult extends Result
{
    public function getRepoFullName(): RepoFullName;
}
