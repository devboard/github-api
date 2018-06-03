<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllLabelsQuery;
use DevboardLib\GitHubApi\Query\Repository\Result\AllLabelsResult;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi;

class LabelObjectApi
{
    /** @var LabelApi */
    private $labelApi;

    /** @var LabelFactory */
    private $labelFactory;

    public function __construct(LabelApi $labelApi, LabelFactory $labelFactory)
    {
        $this->labelApi     = $labelApi;
        $this->labelFactory = $labelFactory;
    }

    public function getLabels(AllLabelsQuery $query): AllLabelsResult
    {
        $data = $this->labelApi->getLabels($query);

        $results = [];

        foreach ($data['data']['repository']['labels']['edges'] as $item) {
            $results[] = $this->labelFactory->create($item['node']);
        }

        return new AllLabelsResult($query->getRepoFullName(), $results);
    }
}
