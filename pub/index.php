<?php

declare(strict_types=1);

require __DIR__ . '/../src/Framework/Core/Require/errors.php';
require __DIR__ . '/../vendor/autoload.php';

use Lamahive\Hive\Framework\Core\Kernel;

$kernel = new Kernel();
/** @noinspection PhpUnhandledExceptionInspection */
$kernel->boot(true);
