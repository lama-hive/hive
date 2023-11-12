<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Exception\File\FileNotFoundException;
use Lamahive\Hive\Framework\Exception\File\FileOpenException;
use function fclose;
use function fgets;
use function file_exists;
use function fopen;
use function is_resource;

readonly class File
{
    public string $name;
    private mixed $stream;

    /**
     * @throws FileOpenException
     * @throws FileNotFoundException
     */
    public function __construct(string $name)
    {
        $this->open($name);
    }

    public function __destruct()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
    }

    /**
     * Reads next line in the file and moves pointer.
     * @return string|null When null is returned, end of file is reached.
     */
    public function getLine(): ?string
    {
        $line = fgets($this->stream);

        return $line !== false ? $line : null;
    }

    /**
     * @throws FileOpenException
     * @throws FileNotFoundException
     */
    private function open(string $name): void
    {
        if (!file_exists($name)) {
            throw new FileNotFoundException($name);
        }

        $this->stream = fopen($name, 'r');
        if ($this->stream === false) {
            throw new FileOpenException($name);
        }

        $this->name = $name;
    }
}
