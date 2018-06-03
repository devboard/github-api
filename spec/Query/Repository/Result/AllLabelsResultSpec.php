<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\Query\Repository\Result;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Query\Repository\Result\AllLabelsResult;
use DevboardLib\GitHubApi\Query\Repository\Result\RepositoryResult;
use PhpSpec\ObjectBehavior;

class AllLabelsResultSpec extends ObjectBehavior
{
    public function let(RepoFullName $repoFullName, GitHubLabel $label)
    {
        $this->beConstructedWith($repoFullName, [$label]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AllLabelsResult::class);
        $this->shouldImplement(RepositoryResult::class);
    }
}
