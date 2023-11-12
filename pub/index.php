<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new \Lamahive\Skill\Framework\Bootstrap();
$bootstrap->run('dev');