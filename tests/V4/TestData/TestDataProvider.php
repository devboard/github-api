<?php

declare(strict_types=1);

namespace Tests\DevboardLib\GitHubApi\V4\TestData;

use Symfony\Component\Finder\Finder;

class TestDataProvider
{
    public function getGitHubV4BranchData(): array
    {
        $results = [];

        $finder = new Finder();

        $files = $finder->files()->in(__DIR__)->name('branches.json')->getIterator();

        foreach ($files as $file) {
            $data      = json_decode($file->getContents(), true);
            $results[] = $data;
        }

        return $results;
    }

    public function getGitHubV4LabelData(): array
    {
        $results = [];

        $finder = new Finder();

        $files = $finder->files()->in(__DIR__)->name('labels.json')->getIterator();

        foreach ($files as $file) {
            $data      = json_decode($file->getContents(), true);
            $results[] = $data;
        }

        return $results;
    }

    public function getGitHubV4MilestoneData(): array
    {
        $results = [];

        $finder = new Finder();

        $files = $finder->files()->in(__DIR__)->name('milestones.json')->getIterator();

        foreach ($files as $file) {
            $data      = json_decode($file->getContents(), true);
            $results[] = $data;
        }

        return $results;
    }
}
