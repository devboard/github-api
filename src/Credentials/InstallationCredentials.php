<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Credentials;

use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\User\UserId;

class InstallationCredentials implements Credentials
{
    /** @var InstallationId */
    private $installationId;

    /** @var UserId|null */
    private $userId;

    public function __construct(InstallationId $installationId, ?UserId $userId)
    {
        $this->installationId = $installationId;
        $this->userId         = $userId;
    }

    public static function create(int $installationId, ?int $userId): self
    {
        if (null !== $userId) {
            $userId = new UserId($userId);
        }

        return new self(new InstallationId($installationId), $userId);
    }

    public function getInstallationId(): InstallationId
    {
        return $this->installationId;
    }

    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    public function getInstallationIdValue(): int
    {
        return $this->installationId->getId();
    }

    public function getUserIdValue(): ?int
    {
        if (null === $this->userId) {
            return null;
        }

        return $this->userId->getId();
    }

    public function serialize(): array
    {
        if (null === $this->userId) {
            $userId = null;
        } else {
            $userId = $this->userId->serialize();
        }

        return ['installationId' => $this->installationId->serialize(), 'userId' => $userId];
    }

    public static function deserialize(array $data): self
    {
        if (null === $data['userId']) {
            $userId = null;
        } else {
            $userId = UserId::deserialize($data['userId']);
        }

        return new self(InstallationId::deserialize($data['installationId']), $userId);
    }
}
