<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Http;

readonly class Request
{
    public string $method, $uri, $host;

    public function __construct()
    {
        $this->parseRequest();
    }

    private function parseRequest(): void
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
        $this->uri = $_SERVER['REQUEST_URI'] ?? 'UNKNOWN';
        $this->host = $_SERVER['HTTP_HOST'] ?? 'UNKNOWN';
    }
}
