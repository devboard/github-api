<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V3\Installation\Factory\Repo;

use DevboardLib\GitHub\GitHubRepo;
use DevboardLib\GitHub\Repo\RepoEndpoints;
use DevboardLib\GitHub\Repo\RepoOwner;
use DevboardLib\GitHub\Repo\RepoStats;
use DevboardLib\GitHub\Repo\RepoTimestamps;
use DevboardLib\GitHubApi\V3\Installation\Factory\GitHubRepoFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoEndpointsFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoOwnerFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoStatsFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoTimestampsFactory;
use PhpSpec\ObjectBehavior;

class GitHubRepoFactorySpec extends ObjectBehavior
{
    public function let(
        RepoOwnerFactory $ownerFactory,
        RepoEndpointsFactory $endpointsFactory,
        RepoTimestampsFactory $timestampsFactory,
        RepoStatsFactory $statsFactory
    ) {
        $this->beConstructedWith($ownerFactory, $endpointsFactory, $timestampsFactory, $statsFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(GitHubRepoFactory::class);
    }

    public function it_will_return_github_repo_instance(
        RepoOwnerFactory $ownerFactory,
        RepoEndpointsFactory $endpointsFactory,
        RepoTimestampsFactory $timestampsFactory,
        RepoStatsFactory $statsFactory,
        RepoOwner $owner,
        RepoEndpoints $endpoints,
        RepoTimestamps $timestamps,
        RepoStats $stats
    ) {
        $provider = JsonSource::create();
        $repos    = $provider->getRepos();
        $data     = array_pop($repos);

        $ownerFactory->create($data)->shouldBeCalled()->willReturn($owner);
        $endpointsFactory->create($data)->shouldBeCalled()->willReturn($endpoints);
        $timestampsFactory->create($data)->shouldBeCalled()->willReturn($timestamps);
        $statsFactory->create($data)->shouldBeCalled()->willReturn($stats);

        $this->create($data)->shouldReturnAnInstanceOf(GitHubRepo::class);
    }
}
