<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\Generix\QueryResult;
use DevboardLib\GitHub\Repo\RepoFullName;

interface RepositoryResult extends QueryResult
{
    public function getRepoFullName(): RepoFullName;
}
