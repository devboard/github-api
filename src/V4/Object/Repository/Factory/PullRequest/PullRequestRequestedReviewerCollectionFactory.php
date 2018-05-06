<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequest;

use DevboardLib\GitHub\PullRequest\PullRequestRequestedReviewerCollection;

class PullRequestRequestedReviewerCollectionFactory
{
    /** @var PullRequestRequestedReviewerFactory */
    private $requestedReviewerFactory;

    public function __construct(PullRequestRequestedReviewerFactory $requestedReviewerFactory)
    {
        $this->requestedReviewerFactory = $requestedReviewerFactory;
    }

    public function create(array $data): PullRequestRequestedReviewerCollection
    {
        $results = [];

        foreach ($data as $item) {
            $results[] = $this->requestedReviewerFactory->create($item['node']['requestedReviewer']);
        }

        return new PullRequestRequestedReviewerCollection($results);
    }
}
