<?php

namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldAuth;

class Auth extends ShieldAuth
{
    // Overrides for API authentication
    public string $defaultAuthenticator = 'tokens';

    public array $authenticationChain = [
        'tokens',
    ];

    public bool $allowMagicLinkLogins = false;

    public array $sessionConfig = [
        'field'              => 'user',
        'allowRemembering'   => false, // No sessions for API
        'rememberCookieName' => 'remember',
        'rememberLength'     => 0,
    ];
}
