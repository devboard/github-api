<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\LabelFactory;
use DevboardLib\GitHubApi\V4\Repository\LabelApi;
use PhpSpec\ObjectBehavior;

class LabelApiSpec extends ObjectBehavior
{
    public function let(GitHubClientFactory $clientFactory, LabelFactory $labelFactory)
    {
        $this->beConstructedWith($clientFactory, $labelFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LabelApi::class);
    }
}
