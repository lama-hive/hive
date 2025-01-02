<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Logs;

use Exception;
use Lamahive\Hive\Framework\Core\Exception\CoreException;
use Lamahive\Hive\Framework\Http\Request;
use Lamahive\Hive\Framework\Utils\Clock;
use function sprintf;

readonly class Logger
{
    public const string LOGS_DIR = 'logs';

    /**
     * @throws FilesystemException
     */
    public function __construct(private Request $request, private Clock $clock)
    {

    }

    /**
     * @throws CoreException
     */
    private function formatExceptionMessage(string $message, Exception $e): string
    {
        return sprintf(
            "[%s] %s: %s in %s:%s via %s\n",
            $this->clock->getUtcDateTime()->format('Y-m-d H:i:s'),
            $message,
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $this->request->uri
        );
    }
}
