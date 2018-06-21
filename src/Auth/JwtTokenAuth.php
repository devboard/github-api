<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Auth;

/**
 * @see JwtTokenAuthSpec
 * @see JwtTokenAuthTest
 */
class JwtTokenAuth implements AuthMethod
{
    /** @var string */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getTokenOrLogin(): string
    {
        return $this->token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getLogin(): ?string
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function getAuthMethod(): string
    {
        // This is value of Github\Client::AUTH_JWT
        return 'jwt';
    }

    public function serialize(): string
    {
        return $this->token;
    }

    public static function deserialize(string $token): self
    {
        return new self($token);
    }
}
