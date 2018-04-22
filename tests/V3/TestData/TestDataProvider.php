<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V3\TestData;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\Thesting\Source\JsonSource;
use Exception;
use Symfony\Component\Finder\Finder;

class TestDataProvider
{
    /** @var JsonSource */
    private $source;

    public function __construct()
    {
        $this->source = JsonSource::create();
    }

    public function getGitHubRepo(string $fullName): array
    {
        return $this->source->getRepo($fullName);
    }

    public function getGitHubRepoAndBranches(string $fullName): array
    {
        foreach ($this->source->getRepos() as $repo) {
            if ($fullName === $repo['full_name']) {
                $branches = $this->source->getBranches($fullName);

                return ['repo' => $repo, 'branches' => $branches];
            }
        }

        throw new Exception('Cant find any data for '.$fullName);
    }

    public function getGitHubRepoAndTags(string $fullName): array
    {
        foreach ($this->source->getRepos() as $repo) {
            if ($fullName === $repo['full_name']) {
                $tags = $this->source->getTags($fullName);
                foreach ($tags as &$tag) {
                    $tag['commit'] = $this->source->getCommit($fullName, $tag['commit']['sha']);
                }

                return ['repo' => $repo, 'tags' => $tags];
            }
        }

        throw new Exception('Cant find any data for '.$fullName);
    }

    public function getGitHubRepoData(): array
    {
        $results = [];

        foreach ($this->source->getRepos() as $repo) {
            $results[] = [$repo];
        }

        return $results;
    }

    public function getGitHubBranchesData(): array
    {
        $results = [];

        foreach ($this->source->getSupportedRepoNames() as $repoName) {
            foreach ($this->source->getBranches($repoName) as $branch) {
                $results[] = [$branch, RepoFullName::createFromString($repoName)];
            }
        }

        return $results;
    }

    public function getGitHubBranchesDataWithRepo(): array
    {
        $results = [];

        foreach ($this->source->getRepos() as $repoName => $repoData) {
            $results[] = ['repo' => $repoData, 'branches' => $this->source->getBranches($repoName)];
        }

        return $results;
    }

    public function getGitHubTagsData(): array
    {
        $results = [];

        foreach ($this->source->getSupportedRepoNames() as $repoName) {
            foreach ($this->source->getTags($repoName) as $tag) {
                $tag['commit'] = $this->source->getCommit($repoName, $tag['commit']['sha']);

                $results[] = [$tag, RepoFullName::createFromString($repoName)];
            }
        }

        return $results;
    }

    public function getGitHubTagsDataWithRepo(): array
    {
        $results = [];

        foreach ($this->source->getRepos() as $repoName => $repoData) {
            $results[] = ['repo' => $repoData, 'tags' => $this->source->getTags($repoName)];
        }

        return $results;
    }

    public function getCommitStatusesWithRepo(): array
    {
        $results = [];

        foreach ($this->source->getRepos() as $repoName => $repoData) {
            $results[] = ['repo' => $repoData, 'commitStatuses' => $this->source->getCommitsStatuses($repoName)];
        }

        return $results;
    }

    public function getCommitStatuses(): array
    {
        $results = [];

        foreach (array_keys($this->source->getRepos()) as $repoName) {
            foreach ($this->source->getCommitsStatuses($repoName) as $commitStatuses) {
                foreach ($commitStatuses as $commitStatus) {
                    $results[] = $commitStatus;
                }
            }
        }

        return $results;
    }

    public function getCommitStatuses2(string $repo, string $commitSha): array
    {
        return $this->source->getCommitStatus($repo, $commitSha);
    }

    public function getPullRequests(): array
    {
        $results = [];

        foreach ($this->source->getRepos() as $repoName => $repoData) {
            $results[] = ['repo' => $repoData, 'pullRequests' => $this->source->getPullRequests($repoName)];
        }

        return $results;
    }

    public function getGitHubInstallationData(): array
    {
        $results = [];

        $finder = new Finder();

        $files = $finder->files()->in(__DIR__.'/../TestData/')->name('installations.json')->getIterator();

        foreach ($files as $file) {
            $data = json_decode($file->getContents(), true);
            foreach ($data['installations'] as $installation) {
                $results[] = [$installation];
            }
        }

        return $results;
    }

    public function getGitHubInstallationRepositoriesData(): array
    {
        $results = [];

        $finder = new Finder();

        $files = $finder->files()->in(__DIR__.'/../TestData/')->name('installation-repositories.json')->getIterator();

        foreach ($files as $file) {
            $data = json_decode($file->getContents(), true);
            foreach ($data['repositories'] as $repository) {
                $results[] = [$repository];
            }
        }

        return $results;
    }
}
