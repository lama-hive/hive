<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;

readonly class Read
{
    public function __construct(private Root $root) {}



    /**
     * @throws FilesystemException
     */
    public function file(string $path, string $filename): ReadableFile
    {
        $fullPath = $this->root->path . $path;
        $filepath = $fullPath . $filename;

        $resource = fopen($fullPath, 'r');
        if ($resource === false) {
            throw new FilesystemException("Could not locate file to read. Path: $fullPath");
        }

        return new ReadableFile($resource, $filepath);
    }
}
