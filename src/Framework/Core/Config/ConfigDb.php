<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Core\Config;

class ConfigDb extends AbstractConfig
{
    public const string FILENAME = 'Db.json';

    public function __construct()
    {
        parent::__construct(self::FILENAME);
    }

    public function getHost(): string
    {
        return $this->configData->get('host');
    }
}
