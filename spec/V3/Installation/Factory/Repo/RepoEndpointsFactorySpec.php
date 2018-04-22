<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\Repo\RepoEndpoints;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoEndpointsFactory;
use DevboardLib\Thesting\Source\JsonSource;
use PhpSpec\ObjectBehavior;

class RepoEndpointsFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RepoEndpointsFactory::class);
    }

    public function it_will_return_github_endpoints_instance()
    {
        $repos = JsonSource::create()->getRepos();
        $data  = array_pop($repos);

        $this->create($data)->shouldReturnAnInstanceOf(RepoEndpoints::class);
    }
}
