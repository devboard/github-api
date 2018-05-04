<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\LabelFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\LabelObjectApi;
use DevboardLib\GitHubApi\V4\Raw\Repository\LabelApi;
use PhpSpec\ObjectBehavior;

class LabelObjectApiSpec extends ObjectBehavior
{
    public function let(LabelApi $labelApi, LabelFactory $labelFactory)
    {
        $this->beConstructedWith($labelApi, $labelFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LabelObjectApi::class);
    }
}
