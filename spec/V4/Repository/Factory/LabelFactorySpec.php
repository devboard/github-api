<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHubApi\V4\Repository\Factory\LabelFactory;
use PhpSpec\ObjectBehavior;

class LabelFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(LabelFactory::class);
    }
}
