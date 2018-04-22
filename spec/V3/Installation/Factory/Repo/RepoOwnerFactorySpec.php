<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoOwner;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoOwnerFactory;
use DevboardLib\Thesting\Source\JsonSource;
use PhpSpec\ObjectBehavior;

class RepoOwnerFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RepoOwnerFactory::class);
    }

    public function it_will_return_github_repo_owner_instance()
    {
        $repos = JsonSource::create()->getRepos();
        $data  = array_pop($repos);

        $this->create($data)->shouldReturnAnInstanceOf(RepoOwner::class);
    }
}
