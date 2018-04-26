<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHub\Account\AccountApiUrl;
use DevboardLib\GitHub\Account\AccountAvatarUrl;
use DevboardLib\GitHub\Account\AccountHtmlUrl;
use DevboardLib\GitHub\Account\AccountId;
use DevboardLib\GitHub\Account\AccountLogin;
use DevboardLib\GitHub\Account\AccountType;
use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\Milestone\MilestoneApiUrl;
use DevboardLib\GitHub\Milestone\MilestoneClosedAt;
use DevboardLib\GitHub\Milestone\MilestoneCreatedAt;
use DevboardLib\GitHub\Milestone\MilestoneCreator;
use DevboardLib\GitHub\Milestone\MilestoneDescription;
use DevboardLib\GitHub\Milestone\MilestoneDueOn;
use DevboardLib\GitHub\Milestone\MilestoneHtmlUrl;
use DevboardLib\GitHub\Milestone\MilestoneId;
use DevboardLib\GitHub\Milestone\MilestoneNumber;
use DevboardLib\GitHub\Milestone\MilestoneState;
use DevboardLib\GitHub\Milestone\MilestoneTitle;
use DevboardLib\GitHub\Milestone\MilestoneUpdatedAt;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MilestoneFactory
{
    public function create(array $data): GitHubMilestone
    {
        if (null === $data['dueOn']) {
            $dueOn = null;
        } else {
            $dueOn = new MilestoneDueOn($data['dueOn']);
        }
        if (null === $data['closedAt']) {
            $closedAt = null;
        } else {
            $closedAt = new MilestoneClosedAt($data['closedAt']);
        }

        return new GitHubMilestone(
            new MilestoneId((int) $data['id']),
            new MilestoneTitle($data['title']),
            new MilestoneDescription($data['description']),
            $dueOn,
            new MilestoneState(strtolower($data['state'])),
            new MilestoneNumber($data['number']),
            $this->createCreator($data['creator']),
            new MilestoneHtmlUrl('TODO'),
            new MilestoneApiUrl('TODO'),
            $closedAt,
            new MilestoneCreatedAt($data['createdAt']),
            new MilestoneUpdatedAt($data['updatedAt'])
        );
    }

    public function createCreator(array $data): MilestoneCreator
    {
        return new MilestoneCreator(
            new AccountId((int) $data['id']),
            new AccountLogin($data['login']),
            new AccountType($data['__typename']),
            new AccountAvatarUrl($data['avatarUrl']),
            null,
            new AccountHtmlUrl('TODO'),
            new AccountApiUrl('TODO'),
            $data['isSiteAdmin']
        );
    }
}
