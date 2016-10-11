<?php

return [
    'dependencies' => [
        'factories' => [
            League\OAuth2\Server\AuthorizationServer::class => Starcode\Staff\Authorization\Service\AuthorizationServerFactory::class,
            League\OAuth2\Server\Grant\PasswordGrant::class => Starcode\Staff\Authorization\Service\PasswordGrantFactory::class,
        ],
    ],
    'authorization' => [
        'access_token_ttl' => 'PT1H',
        'refresh_token_ttl' => 'P1M',
    ],
];