<?php

declare(strict_types=1);

return [
    /**
     * Framework
     */
    'framework.logger.name' => 'general',
    'framework.logger.log.path' => __DIR__ . '/logs/general.log',

    \Lamahive\Skill\Framework\Db\Db::class => Di\create()
        ->constructor(
            host: Di\get('db.host'),
            port: Di\get('db.port'),
            name: Di\get('db.name'),
            username: Di\get('db.username'),
            password: Di\get('db.password'),
            charset: Di\get('db.charset')
        ),
    \Lamahive\Skill\Framework\Framework::class => Di\create()
        ->constructor(
            debug: Di\get('framework.debug')
        ),
    \Lamahive\Skill\Framework\Logger\Logger::class => Di\create()
        ->constructor(
            name: Di\get('framework.logger.name'),
            handlers: [
                Di\create(\Lamahive\Skill\Framework\Logger\StreamHandler::class)
                    ->constructor(
                        stream: Di\get('framework.logger.log.path'),
                        level: Di\get('framework.logger.log.level')
                    ),
            ]
        )
];
