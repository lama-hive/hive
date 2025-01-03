<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Core;

use Exception;
use Lamahive\Hive\Framework\Core\Exception\BootException;
use Lamahive\Hive\Framework\Core\Exception\CoreException;
use Lamahive\Hive\Framework\Logs\Logger;

class Kernel
{
    private Logger $logger;

    private bool $debug = false;

    /**
     * @throws BootException
     */
    public function boot(bool $debug = false): void
    {
        try {
            $this->debug = $debug;

            // Create a new DI container and register the kernel instance
            $di = new DI();
            $di->register(static::class, $this);

            // Get the logger instance from the DI container
            $this->logger = $di->get(Logger::class);
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->crash($e);
        }
    }

    /**
     * @throws BootException
     */
    private function crash(Exception $e): void
    {
        $bootException = new BootException($e->getMessage(), $e->getCode(), $e);

        try {
            $this?->logger->exception("An error occurred while booting the application.", $bootException);
        } catch (FilesystemException|CoreException $loggerException) {
            $bootException = new BootException("{$loggerException->getMessage()} during {$e->getMessage()}", $e->getCode(), $e);
        } finally {
            if ($this->debug) {
                throw $bootException;
            } else {
                echo "An error occurred while booting the application. To see more details, enable the debug mode.";
            }
        }
    }
}
