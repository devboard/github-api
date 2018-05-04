<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoStats;
use DevboardLib\GitHub\Repo\RepoStats\RepoSize;

/**
 * @see RepoStatsFactorySpec
 * @see RepoStatsFactoryTest
 */
class RepoStatsFactory
{
    public function create(array $data): RepoStats
    {
        if (true === array_key_exists('subscribers_count', $data)) {
            $subscribersCount = $data['subscribers_count'];
        } else {
            $subscribersCount = $data['watchers_count'];
        }

        return new RepoStats(
            $data['forks_count'],
            $data['watchers_count'],
            $data['stargazers_count'],
            $subscribersCount,
            $data['open_issues_count'],
            new RepoSize($data['size'])
        );
    }
}
