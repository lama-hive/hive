<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;

/**
 * Representation of the file on the filesystem.
 * It automatically closes the file when it is destroyed.
 */
class File
{
    public readonly string $path;

    /**
     * @var resource|null
     */
    private $resource = null;

    public function __construct($resource, string $path)
    {
        $this->resource = $resource;
        $this->path = $path;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close(): void
    {
        if ($this->resource !== null) {
            fclose($this->resource);

            $this->resource = null;
        }
    }

    /**
     * @throws FilesystemException
     */
    public function write(string $message): void
    {
        if ($this->isClosed()) {
            throw new FilesystemException("File is closed. Path: {$this->path}");
        }

        $result = fwrite($this->resource, $message);
        if ($result === false) {
            throw new FilesystemException("Could not write to file. Path: {$this->path}");
        }
    }

    public function isClosed(): bool
    {
        return $this->resource === null;
    }
}
