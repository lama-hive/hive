<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new \Lamahive\Hive\Framework\Bootstrap();
$bootstrap->run('dev');
