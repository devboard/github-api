<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository\Factory\Repo;

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
        if (is_numeric($data['created_at'])) {
            $createdAt = new RepoCreatedAt(gmdate("Y-m-d\TH:i:s\Z", $data['created_at']));
        } else {
            $createdAt = new RepoCreatedAt($data['created_at']);
        }

        if (is_numeric($data['updated_at'])) {
            $updatedAt = new RepoUpdatedAt(gmdate("Y-m-d\TH:i:s\Z", $data['updated_at']));
        } else {
            $updatedAt = new RepoUpdatedAt($data['updated_at']);
        }

        if (is_numeric($data['pushed_at'])) {
            $pushedAt = new RepoPushedAt(gmdate("Y-m-d\TH:i:s\Z", $data['pushed_at']));
        } else {
            $pushedAt = new RepoPushedAt($data['pushed_at']);
        }

        return new RepoTimestamps($createdAt, $updatedAt, $pushedAt);
    }
}
