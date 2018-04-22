<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\Auth;

interface AuthMethod
{
    public function getTokenOrLogin(): string;

    public function getToken(): string;

    public function getLogin(): ?string;

    public function getPassword(): ?string;

    public function getAuthMethod(): string;
}
