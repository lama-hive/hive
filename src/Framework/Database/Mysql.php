<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Database;

use Lamahive\Hive\Framework\Core\Config\ConfigDb;

readonly class Mysql
{
    public function __construct(private ConfigDb $config){}

    public function connect(): void
    {
        echo "Connecting to MySQL database with the following configuration:\n";
        echo "Host: {$this->config->get('host')}\n";
        echo "Port: {$this->config->get('port')}\n";
        echo "Database: {$this->config->get('database')}\n";
        echo "Username: {$this->config->get('username')}\n";
        echo "Password: {$this->config->get('password')}\n";
    }
}
