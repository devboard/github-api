<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Response;

use DevboardLib\GitHub\GitHubStatus;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use Webmozart\Assert\Assert;

class PullRequestStatusCollection
{
    /** @var PullRequestNumber */
    private $number;

    /** @var array */
    private $statuses;

    public function __construct(PullRequestNumber $number, array $statuses)
    {
        Assert::allIsInstanceOf($statuses, GitHubStatus::class);

        $this->number   = $number;
        $this->statuses = $statuses;
    }

    public function getNumber(): PullRequestNumber
    {
        return $this->number;
    }

    public function getStatuses(): array
    {
        return $this->statuses;
    }
}
