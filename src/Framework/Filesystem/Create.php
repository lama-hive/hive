<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;
use function mkdir;
use function fopen;

readonly class Create
{
    public function __construct(private Root $root) {}

    /**
     * @param string $path Starting without a slash, ending with a slash
     * @throws FilesystemException
     */
    public function path(string $path): void
    {
        $fullPath = $this->root->path . $path;

        if (!mkdir($fullPath, 0755, true)) {
            throw new FilesystemException("Could not create directory path. Path: {$fullPath}");
        }
    }

    /**
     * @param string $path Starting without a slash, ending with a slash. Example: 'dir1/dir2/'.
     * Relative to the framework files folder root.
     * @throws FilesystemException
     */
    public function file(string $path, string $filename): File
    {
        $fullPath = $this->root->path . $path;
        $filepath = $fullPath . $filename;

        $this->path($path);

        $resource = fopen($fullPath, 'a+');
        if ($resource === false) {
            throw new FilesystemException("Could not create file. Path: $fullPath");
        }

        return new File($resource, $filepath);
    }
}
