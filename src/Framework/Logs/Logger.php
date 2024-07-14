<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Logs;

use Exception;
use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;
use Lamahive\Hive\Framework\Http\Request;

class Logger
{
    public const string LOGS_DIR = 'logs';

    private File $file;

    /**
     * @throws FilesystemException
     */
    public function __construct(private readonly Request $request, Create $create)
    {
        $this->file = $create->file(static::LOGS_DIR . '/', 'global.log');
    }

    /**
     * @throws FilesystemException
     */
    public function exception(string $message, Exception $e): void
    {
        $this->file->write($this->format($message, $e));
    }

    private function format(string $message, Exception $e): string
    {
        return sprintf(
            "[%s] %s: %s in %s:%s via %s\n",
            date('Y-m-d H:i:s'),
            $message,
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $this->request->uri
        );
    }
}
