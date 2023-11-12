<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Filesystem;

use Lamahive\Hive\Framework\Exception\File\FileNotFoundException;
use Lamahive\Hive\Framework\Exception\File\FileOpenException;
use Lamahive\Hive\Framework\Exception\File\ReaderNoFileOpenedException;
use Lamahive\Hive\Framework\Exception\File\ReaderSeekingOutOfRangeException;
use function preg_match;

class FileReader
{
    private File $file;

    /**
     * @var int Number of the line, which will be returned next on $this->getLine() call. Counting from 1.
     */
    private int $linePointer;

    /**
     * @throws FileOpenException
     * @throws FileNotFoundException
     */
    public function openFile(string $pathname): void
    {
        $this->file = new File($pathname);

        $this->linePointer = 1;
    }

    /**
     * @throws ReaderNoFileOpenedException
     */
    public function getCurrentLineNumber(): int
    {
        $this->failIfNoFileOpened();

        return $this->linePointer;
    }

    /**
     * @throws ReaderNoFileOpenedException
     */
    public function getLinesUntil(string $pattern): ?string
    {
        $buffer = '';
        $patternFound = false;
        while (($line = $this->getLine()) !== null) {
            $buffer .= $line;

            if (preg_match('/' . $pattern . '/', $line)) {
                $patternFound = true;
                break;
            }
        }

        return $patternFound ? $buffer : null;
    }

    /**
     * @throws ReaderNoFileOpenedException
     * @throws ReaderSeekingOutOfRangeException
     */
    public function seek(int $target): void
    {
        // We can only seek forward.
        if ($this->linePointer > $target) {
            throw new ReaderSeekingOutOfRangeException($this->linePointer, $target, 0);
        }

        do {
            if ($this->linePointer === $target) {
                return;
            }
        } while ($this->getLine() !== null);

        // End of file reached while not reaching the target.
        throw new ReaderSeekingOutOfRangeException($this->linePointer, $target, 1);
    }

    /**
     * @throws ReaderNoFileOpenedException
     */
    public function getLine(): ?string
    {
        $this->failIfNoFileOpened();

        $line = $this->file->getLine();

        if ($line !== null) {
            $this->linePointer++;
        }

        return $line;
    }

    /**
     * @throws ReaderNoFileOpenedException
     */
    private function failIfNoFileOpened(): void
    {
        if (!isset($this->file)) {
            throw new ReaderNoFileOpenedException();
        }
    }
}
