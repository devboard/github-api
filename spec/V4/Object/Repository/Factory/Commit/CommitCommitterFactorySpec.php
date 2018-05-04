<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitCommitterFactory;
use PhpSpec\ObjectBehavior;

class CommitCommitterFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CommitCommitterFactory::class);
    }
}
