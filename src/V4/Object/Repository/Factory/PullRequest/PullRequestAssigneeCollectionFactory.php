<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\PullRequest\PullRequestAssigneeCollection;

class PullRequestAssigneeCollectionFactory
{
    /** @var PullRequestAssigneeFactory */
    private $pullRequestAssigneeFactory;

    public function __construct(PullRequestAssigneeFactory $pullRequestAssigneeFactory)
    {
        $this->pullRequestAssigneeFactory = $pullRequestAssigneeFactory;
    }

    public function create(array $data): PullRequestAssigneeCollection
    {
        $results = [];

        foreach ($data as $item) {
            $results[] = $this->pullRequestAssigneeFactory->create($item['node']);
        }

        return new PullRequestAssigneeCollection($results);
    }
}
