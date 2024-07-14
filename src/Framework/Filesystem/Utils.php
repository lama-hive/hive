<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

class Utils
{
    /**
     * @param array<int, string> $paths
     *
     * @return string
     */
    public function joinPaths(array $paths): string
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }
}
