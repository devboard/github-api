<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\GitHubPullRequestReviewCollection;

class PullRequestReviewCollectionFactory
{
    /** @var PullRequestReviewFactory */
    private $reviewFactory;

    public function __construct(PullRequestReviewFactory $reviewFactory)
    {
        $this->reviewFactory = $reviewFactory;
    }

    public function create(array $data): GitHubPullRequestReviewCollection
    {
        $results = [];

        foreach ($data as $item) {
            $results[] = $this->reviewFactory->create($item['node']);
        }

        return new GitHubPullRequestReviewCollection($results);
    }
}
