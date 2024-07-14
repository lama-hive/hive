<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Logs;

use Exception;
use Lamahive\Hive\Framework\Core\Exception\CoreException;
use Lamahive\Hive\Framework\Filesystem\Create;
use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;
use Lamahive\Hive\Framework\Filesystem\File;
use Lamahive\Hive\Framework\Http\Request;
use Lamahive\Hive\Framework\Utils\Clock;
use function sprintf;

readonly class Logger
{
    public const string LOGS_DIR = 'logs';

    private File $file;

    /**
     * @throws FilesystemException
     */
    public function __construct(private Request $request, private Clock $clock, Create $create)
    {
        $this->file = $create->file(static::LOGS_DIR . '/', 'global.log');
    }

    /**
     * @throws FilesystemException
     * @throws CoreException
     */
    public function exception(string $message, Exception $e): void
    {
        $this->file->write($this->format($message, $e));
    }

    /**
     * @throws CoreException
     */
    private function format(string $message, Exception $e): string
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
