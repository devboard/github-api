<?php

declare(strict_types=1);

namespace spec\DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status\ExternalServiceFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status\StatusCreatorFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\StatusFactory;
use PhpSpec\ObjectBehavior;

class StatusFactorySpec extends ObjectBehavior
{
    public function let(StatusCreatorFactory $statusCreatorFactory, ExternalServiceFactory $externalServiceFactory)
    {
        $this->beConstructedWith($statusCreatorFactory, $externalServiceFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(StatusFactory::class);
    }
}
