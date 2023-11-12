<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Routing;

readonly class Route
{
    public function __construct(public string $httpMethod, public string $pattern, public string $controller, public string $method){}
}
