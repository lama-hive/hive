<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;

class ReadableFile extends File
{
    /**
     * @throws FilesystemException
     */
    public function readAll(): string
    {
        $content = '';
        while (($line = $this->read()) !== false) {
            $content .= $line;
        }

        return $content;
    }

    /**
     * @throws FilesystemException
     */
    public function read(): string|false
    {
        if ($this->isClosed()) {
            throw new FilesystemException("File is closed. Path: {$this->path}");
        }

        return fgets($this->resource);
    }
}
