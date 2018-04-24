<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository\Factory\Commit;

use DevboardLib\GitHubApi\V4\Repository\Factory\Commit\CommitAuthorFactory;
use PhpSpec\ObjectBehavior;

class CommitAuthorFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CommitAuthorFactory::class);
    }
}
