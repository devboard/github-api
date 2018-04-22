<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Auth\GitHubApp;

use DevboardLib\GitHubApi\Auth\JwtTokenAuth;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;

/**
 * @see JwtTokenBuilderSpec
 * @see JwtTokenBuilderTest
 */
class JwtTokenBuilder
{
    /** @var int */
    private $gitHubAppId;

    /** @var string */
    private $gitHubPrivateKeyPath;

    public function __construct(int $gitHubAppId, string $gitHubPrivateKeyPath)
    {
        $this->gitHubAppId          = $gitHubAppId;
        $this->gitHubPrivateKeyPath = $gitHubPrivateKeyPath;
    }

    public function create(): JwtTokenAuth
    {
        $token = (new Builder())
            ->setIssuer((string) $this->gitHubAppId)
            ->setIssuedAt(time())
            ->setExpiration(time() + 60)
            ->sign(new Sha256(), new Key($this->gitHubPrivateKeyPath))
            ->getToken();

        return new JwtTokenAuth($token->__toString());
    }
}
