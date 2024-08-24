<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Core\Config;

use Lamahive\Hive\Framework\Filesystem\Exception\FilesystemException;
use Lamahive\Hive\Framework\Filesystem\Read as FilesystemRead;
use function json_decode;

class ConfigData
{
    private array $data;

    /**
     * @throws FilesystemException
     */
    public function __construct(private readonly string $filename, private readonly FilesystemRead $filesystemRead)
    {
        $this->load();
    }

    /**
     * @throws FilesystemException
     */
    public function get(string $key): string
    {
        /** @todo Data exception, not generic filesystem */
        return $this->data[$key] ?? throw new FilesystemException("Key not found in config data. Key: $key");
    }

    /**
     * @throws FilesystemException
     */
    private function load(): void
    {
        $file = $this->filesystemRead->file('/config', $this->filename);
        $fileString = $file->readAll();

        try {
            $this->data = json_decode($fileString, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            /** @todo Format exception, not generic filesystem */
            throw new FilesystemException("Could not decode JSON file. File: {$file->path}");
        }
    }
}
