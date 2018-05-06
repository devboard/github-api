<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHubApi\Query\Repository\AllMilestonesQuery;
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

    /** @return array|GitHubMilestone[] */
    public function getMilestones(AllMilestonesQuery $query): array
    {
        $data = $this->milestoneApi->getMilestones($query);

        $results = [];

        foreach ($data['data']['repository']['milestones']['edges'] as $item) {
            $results[] = $this->milestoneFactory->create($item['node']);
        }

        return $results;
    }
}
