<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Repo\RepoFullName;
use Webmozart\Assert\Assert;

class AllLabelsResult implements RepositoryResult
{
    /** @var RepoFullName */
    private $repoFullName;

    /** @var array */
    private $labels;

    public function __construct(RepoFullName $repoFullName, array $labels)
    {
        Assert::allIsInstanceOf($labels, GitHubLabel::class);
        $this->repoFullName = $repoFullName;
        $this->labels       = $labels;
    }

    public function getRepoFullName(): RepoFullName
    {
        return $this->repoFullName;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function serialize(): array
    {
        $labels = [];

        foreach ($this->labels as $label) {
            $labels[] = $label->serialize();
        }

        return ['repoFullName' => $this->repoFullName->serialize(), 'labels' => $labels];
    }

    public static function deserialize(array $data): self
    {
        $labels = [];

        foreach ($data['labels'] as $label) {
            $labels[] = GitHubLabel::deserialize($label);
        }

        return new self(RepoFullName::deserialize($data['repoFullName']), $labels);
    }
}
