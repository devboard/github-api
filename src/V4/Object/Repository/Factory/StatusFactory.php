<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DateTime;
use DevboardLib\GitHub\GitHubStatus;
use DevboardLib\GitHub\Status\StatusContext;
use DevboardLib\GitHub\Status\StatusDescription;
use DevboardLib\GitHub\Status\StatusId;
use DevboardLib\GitHub\Status\StatusState;
use DevboardLib\GitHub\Status\StatusTargetUrl;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status\ExternalServiceFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status\StatusCreatorFactory;

class StatusFactory
{
    /** @var StatusCreatorFactory */
    private $statusCreatorFactory;

    /** @var ExternalServiceFactory */
    private $externalServiceFactory;

    public function __construct(
        StatusCreatorFactory $statusCreatorFactory, ExternalServiceFactory $externalServiceFactory
    ) {
        $this->statusCreatorFactory   = $statusCreatorFactory;
        $this->externalServiceFactory = $externalServiceFactory;
    }

    public function create(array $data): GitHubStatus
    {
        $context = new StatusContext($data['context']);

        $id = str_replace('013:StatusContext', '', base64_decode($data['id']));

        return new GitHubStatus(
            new StatusId((int) $id),
            StatusState::create(strtolower($data['state'])),
            new StatusDescription($data['description']),
            new StatusTargetUrl((string) $data['targetUrl']),
            $context,
            $this->externalServiceFactory->create($context),
            $this->statusCreatorFactory->create($data['creator']),
            new DateTime($data['createdAt']),
            new DateTime($data['createdAt'])
        );
    }
}
