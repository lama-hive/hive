<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use DirectoryIterator;
use Generator;
use RecursiveDirectoryIterator;
use function array_merge;

class Directory
{
    /**
     * Finds all files with given extension on level 1 of the given path.
     */
    public static function getFilesByExtension(string $path, string $extension): Generator
    {
        $dir = new DirectoryIterator($path);

        /*** @var $item RecursiveDirectoryIterator */
        foreach ($dir as $item) {
            if ($item->isFile() && $item->getExtension() === $extension) {
                yield $item->getPathname();
            }
        }
    }

    /**
     * Finds all subdirectories on level 1 of the given path.
     */
    public static function getSubdirectories(string $path): Generator
    {
        $dir = new DirectoryIterator($path);

        /*** @var $item RecursiveDirectoryIterator */
        foreach ($dir as $item) {
            if ($item->isDir() && !$item->isDot()) {
                yield $item->getPathname();
            }
        }
    }

    public static function removeDirectoryContent(string $path): array
    {
        $dir = new DirectoryIterator($path);

        $removed = [];
        /*** @var $item RecursiveDirectoryIterator */
        foreach ($dir as $item) {
            if ($item->isFile()) {
                $removed[] = $item->getPathname();

                unlink($item->getPathname());
            } else if ($item->isDir() && !$item->isDot()) {
                $removed = array_merge($removed, static::removeDirectoryContent($item->getPathname()));

                $removed[] = $item->getPathname();

                rmdir($item->getPathname());
            }
        }

        return $removed;
    }
}
