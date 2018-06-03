<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository\Request;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\Request\AllLabelsQuery;
use PhpSpec\ObjectBehavior;

class AllLabelsQuerySpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, InstallationCredentials $credentials)
    {
        $this->beConstructedWith($repoFullName, $credentials);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllLabelsQuery::class);
    }
}
