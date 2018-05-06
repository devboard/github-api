<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHubApi\Query\Repository\AllLabelsQuery;
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

    /** @return array|GitHubLabel[] */
    public function getLabels(AllLabelsQuery $query): array
    {
        $data = $this->labelApi->getLabels($query);

        $results = [];

        foreach ($data['data']['repository']['labels']['edges'] as $item) {
            $results[] = $this->labelFactory->create($item['node']);
        }

        return $results;
    }
}
