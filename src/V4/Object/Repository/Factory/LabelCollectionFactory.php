<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubLabelCollection;

class LabelCollectionFactory
{
    /** @var LabelFactory */
    private $labelFactory;

    public function __construct(LabelFactory $labelFactory)
    {
        $this->labelFactory = $labelFactory;
    }

    public function create(array $data): GitHubLabelCollection
    {
        $results = [];

        foreach ($data as $item) {
            $results[] = $this->labelFactory->create($item['node']);
        }

        return new GitHubLabelCollection($results);
    }
}
