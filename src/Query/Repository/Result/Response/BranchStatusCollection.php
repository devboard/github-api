<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result\Response;

use DevboardLib\Git\Branch\BranchName;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\GitHubStatus;
use Webmozart\Assert\Assert;

class BranchStatusCollection
{
    /** @var BranchName */
    private $branchName;

    /** @var CommitSha */
    private $sha;

    /** @var array */
    private $statuses;

    public function __construct(BranchName $branchName, CommitSha $sha, array $statuses)
    {
        Assert::allIsInstanceOf($statuses, GitHubStatus::class);

        $this->branchName = $branchName;
        $this->sha        = $sha;
        $this->statuses   = $statuses;
    }

    public function getBranchName(): BranchName
    {
        return $this->branchName;
    }

    public function getSha(): CommitSha
    {
        return $this->sha;
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

        return [
            'branchName' => $this->branchName->serialize(),
            'sha'        => $this->sha->serialize(),
            'statuses'   => $statuses,
        ];
    }

    public static function deserialize(array $data): self
    {
        $statuses = [];

        foreach ($data['statuses'] as $label) {
            $statuses[] = GitHubStatus::deserialize($label);
        }

        return new self(
            BranchName::deserialize($data['branchName']), CommitSha::deserialize($data['sha']), $statuses
        );
    }
}
