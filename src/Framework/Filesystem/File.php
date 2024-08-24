<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;
use function fclose;
use function fwrite;

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
    protected $resource;

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

    public function isClosed(): bool
    {
        return $this->resource === null;
    }
}
