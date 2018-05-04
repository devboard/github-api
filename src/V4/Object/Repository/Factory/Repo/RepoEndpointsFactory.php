<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoEndpoints;
use DevboardLib\GitHub\Repo\RepoEndpoints\RepoApiUrl;
use DevboardLib\GitHub\Repo\RepoEndpoints\RepoGitUrl;
use DevboardLib\GitHub\Repo\RepoEndpoints\RepoHtmlUrl;
use DevboardLib\GitHub\Repo\RepoEndpoints\RepoSshUrl;

/**
 * @see RepoEndpointsFactorySpec
 * @see RepoEndpointsFactoryTest
 */
class RepoEndpointsFactory
{
    public function create(array $data): RepoEndpoints
    {
        return new RepoEndpoints(
            new RepoHtmlUrl($data['html_url']),
            new RepoApiUrl($data['url']),
            new RepoGitUrl($data['git_url']),
            new RepoSshUrl($data['ssh_url'])
        );
    }
}
