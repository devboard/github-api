<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestDetailedResponse;
use Webmozart\Assert\Assert;

class AllPullRequestsResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array */
    private $pullRequestDetailedResponses;

    public function __construct(RepoFullName $repoFullName, array $pullRequestDetailedResponses)
    {
        Assert::allIsInstanceOf($pullRequestDetailedResponses, PullRequestDetailedResponse::class);
        $this->repoFullName                 = $repoFullName;
        $this->pullRequestDetailedResponses = $pullRequestDetailedResponses;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getPullRequestDetailedResponses(): array
    {
        return $this->pullRequestDetailedResponses;
    }

    public function serialize(): array
    {
        $pullRequestDetailedResponses = [];

        foreach ($this->pullRequestDetailedResponses as $pullRequestDetailedResponse) {
            $pullRequestDetailedResponses[] = $pullRequestDetailedResponse->serialize();
        }

        return [
            'repoFullName'                 => $this->repoFullName->serialize(),
            'pullRequestDetailedResponses' => $pullRequestDetailedResponses,
        ];
    }

    public static function deserialize(array $data): self
    {
        $pullRequestDetailedResponses = [];

        foreach ($data['pullRequestDetailedResponses'] as $pullRequestDetailedResponse) {
            $pullRequestDetailedResponses[] = PullRequestDetailedResponse::deserialize($pullRequestDetailedResponse);
        }

        return new self(RepoFullName::deserialize($data['repoFullName']), $pullRequestDetailedResponses);
    }
}
