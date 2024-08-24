<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Core\Config;

abstract class AbstractConfig
{
    protected ConfigData $configData;

    public function __construct(protected string $filename)
    {
        $this->configData = new ConfigData($this->filename);
    }
}
