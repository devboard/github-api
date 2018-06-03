<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\Query\Repository\Request\AllMilestonesQuery;
use DevboardLib\GitHubApi\Query\Repository\Result\AllMilestonesResult;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\MilestoneFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\MilestoneApi;

class MilestoneObjectApi
{
    /** @var MilestoneApi */
    private $milestoneApi;

    /** @var MilestoneFactory */
    private $milestoneFactory;

    public function __construct(MilestoneApi $milestoneApi, MilestoneFactory $milestoneFactory)
    {
        $this->milestoneApi     = $milestoneApi;
        $this->milestoneFactory = $milestoneFactory;
    }

    public function handleAllMilestonesQuery(AllMilestonesQuery $query): AllMilestonesResult
    {
        $data = $this->milestoneApi->handleAllMilestonesQuery($query);

        $results = [];

        foreach ($data['data']['repository']['milestones']['edges'] as $item) {
            $results[] = $this->milestoneFactory->create($item['node']);
        }

        return new AllMilestonesResult($query->getRepoFullName(), $results);
    }
}
