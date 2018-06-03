<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository\Request;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\Request\AllBranchesQuery;
use DevboardLib\GitHubApi\Query\Repository\Request\RepositoryQuery;
use PhpSpec\ObjectBehavior;

class AllBranchesQuerySpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, InstallationCredentials $credentials)
    {
        $this->beConstructedWith($repoFullName, $credentials);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllBranchesQuery::class);
        $this->shouldImplement(RepositoryQuery::class);
    }
}
