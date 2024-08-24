<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;

class WriteableFile extends File
{
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
}
