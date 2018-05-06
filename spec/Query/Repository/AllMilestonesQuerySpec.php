<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\Query\Repository\AllMilestonesQuery;
use PhpSpec\ObjectBehavior;

class AllMilestonesQuerySpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, InstallationCredentials $credentials)
    {
        $this->beConstructedWith($repoFullName, $credentials);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllMilestonesQuery::class);
    }
}
