<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Response;

use DevboardLib\GitHub\GitHubStatus;
use DevboardLib\GitHub\PullRequest\PullRequestNumber;
use DevboardLib\GitHubApi\V4\Object\Repository\Response\PullRequestStatusCollection;
use PhpSpec\ObjectBehavior;

class PullRequestStatusCollectionSpec extends ObjectBehavior
{
    public function let(PullRequestNumber $number, GitHubStatus $status1)
    {
        $this->beConstructedWith($number, [$status1]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PullRequestStatusCollection::class);
    }
}
