<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status\StatusCreatorFactory;
use PhpSpec\ObjectBehavior;

class StatusCreatorFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(StatusCreatorFactory::class);
    }
}
