<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V3\Installation\Factory;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\GitHub\GitHubRepo;
use DevboardLib\GitHub\Repo\RepoDescription;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\Repo\RepoHomepage;
use DevboardLib\GitHub\Repo\RepoId;
use DevboardLib\GitHub\Repo\RepoLanguage;
use DevboardLib\GitHub\Repo\RepoMirrorUrl;
use DevboardLib\GitHub\Repo\RepoParent;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoEndpointsFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoOwnerFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoStatsFactory;
use DevboardLib\GitHubApi\V3\Installation\Factory\Repo\RepoTimestampsFactory;

/**
 * @see GitHubRepoFactorySpec
 * @see GitHubRepoFactoryTest
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class GitHubRepoFactory
{
    /** @var RepoOwnerFactory */
    private $ownerFactory;

    /** @var RepoEndpointsFactory */
    private $endpointsFactory;

    /** @var RepoTimestampsFactory */
    private $timestampsFactory;

    /** @var RepoStatsFactory */
    private $statsFactory;

    public function __construct(
        RepoOwnerFactory $ownerFactory,
        RepoEndpointsFactory $endpointsFactory,
        RepoTimestampsFactory $timestampsFactory,
        RepoStatsFactory $statsFactory
    ) {
        $this->ownerFactory      = $ownerFactory;
        $this->endpointsFactory  = $endpointsFactory;
        $this->timestampsFactory = $timestampsFactory;
        $this->statsFactory      = $statsFactory;
    }

    public function create(array $data): GitHubRepo
    {
        if (true === $data['fork'] && true === array_key_exists('parent', $data)) {
            $parent = new RepoParent(
                new RepoId($data['parent']['id']), RepoFullName::createFromString($data['parent']['full_name'])
            );
        } else {
            $parent = null;
        }

        if (null !== $data['description']) {
            $description = new RepoDescription($data['description']);
        } else {
            $description = null;
        }

        if (null !== $data['mirror_url']) {
            $mirrorUrl = new RepoMirrorUrl($data['mirror_url']);
        } else {
            $mirrorUrl = null;
        }

        if (null !== $data['homepage']) {
            $homepage = new RepoHomepage($data['homepage']);
        } else {
            $homepage = null;
        }

        if (null !== $data['language']) {
            $language = new RepoLanguage($data['language']);
        } else {
            $language = null;
        }

        if (true === array_key_exists('archived', $data)) {
            $archived = $data['archived'];
        } else {
            $archived = null;
        }

        $repo = new GitHubRepo(
            new RepoId($data['id']),
            RepoFullName::createFromString($data['full_name']),
            $this->ownerFactory->create($data),
            $data['private'],
            new BranchName($data['default_branch']),
            $data['fork'],
            $parent,
            $description,
            $homepage,
            $language,
            $mirrorUrl,
            $archived,
            $this->endpointsFactory->create($data),
            $this->statsFactory->create($data),
            $this->timestampsFactory->create($data)
        );

        return $repo;
    }
}
