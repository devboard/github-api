<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHubApi\V4\Repository\Factory\Commit\CommitAuthorFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\Commit\CommitCommitterFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\CommitFactory;
use PhpSpec\ObjectBehavior;

class CommitFactorySpec extends ObjectBehavior
{
    public function let(CommitCommitterFactory $committerFactory, CommitAuthorFactory $authorFactory)
    {
        $this->beConstructedWith($committerFactory, $authorFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CommitFactory::class);
    }
}
