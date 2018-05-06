<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelCollectionFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelFactory;
use PhpSpec\ObjectBehavior;

class LabelCollectionFactorySpec extends ObjectBehavior
{
    public function let(LabelFactory $labelFactory)
    {
        $this->beConstructedWith($labelFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LabelCollectionFactory::class);
    }
}
