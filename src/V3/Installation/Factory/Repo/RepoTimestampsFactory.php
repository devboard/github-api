<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoCreatedAt;
use DevboardLib\GitHub\Repo\RepoPushedAt;
use DevboardLib\GitHub\Repo\RepoTimestamps;
use DevboardLib\GitHub\Repo\RepoUpdatedAt;

/**
 * @see RepoTimestampsFactorySpec
 * @see RepoTimestampsFactoryTest
 */
class RepoTimestampsFactory
{
    public function create(array $data): RepoTimestamps
    {
        return new RepoTimestamps(
            new RepoCreatedAt($data['created_at']),
            new RepoUpdatedAt($data['updated_at']),
            new RepoPushedAt($data['pushed_at'])
        );
    }
}
