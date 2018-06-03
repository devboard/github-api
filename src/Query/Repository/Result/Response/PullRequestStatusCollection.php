<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result\Response;

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

    public function serialize(): array
    {
        $statuses = [];

        foreach ($this->statuses as $label) {
            $statuses[] = $label->serialize();
        }

        return ['number' => $this->number->serialize(), 'statuses' => $statuses];
    }

    public static function deserialize(array $data): self
    {
        $statuses = [];

        foreach ($data['statuses'] as $label) {
            $statuses[] = GitHubStatus::deserialize($label);
        }

        return new self(PullRequestNumber::deserialize($data['number']), $statuses);
    }
}
