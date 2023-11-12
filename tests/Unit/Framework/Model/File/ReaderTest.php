<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Lamahive\Hive\Framework\Exception\File\FileNotFoundException;
use Lamahive\Hive\Framework\Exception\File\ReaderNoFileOpenedException;
use Lamahive\Hive\Framework\Exception\File\ReaderSeekingOutOfRangeException;
use Lamahive\Hive\Framework\Filesystem\FileReader;

const READER_TEST_FILEPATH = __DIR__ . '/test';

test('opens file', function () {
    $reader = new FileReader();
    $exceptionCaught = false;

    try {
        $reader->openFile(READER_TEST_FILEPATH);
    } catch (Exception $e) {
        $exceptionCaught = true;
    }

    expect($exceptionCaught)->toBeFalse();
});

test('fails with wrong filename', function () {
   $reader = new FileReader();

   $reader->openFile('fail');
})->throws(FileNotFoundException::class);

test('fails without open: getLine', function () {
    $reader = new FileReader();

    $reader->getLine();
})->throws(ReaderNoFileOpenedException::class);

test('fails without open: getCurrentLineNumber', function () {
    $reader = new FileReader();

    $reader->getCurrentLineNumber();
})->throws(ReaderNoFileOpenedException::class);

test('fails without open: getLinesUntil', function () {
    $reader = new FileReader();

    $reader->getLinesUntil(';');
})->throws(ReaderNoFileOpenedException::class);

test('gives correct line number: start', function () {
   $reader = new FileReader();


   $reader->openFile(READER_TEST_FILEPATH);

   $currentLineNumber = $reader->getCurrentLineNumber();

   expect($currentLineNumber)->toBeInt()->toEqual(1);
});

test('gives correct line number: inside', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);

    for ($i = 0; $i < 4; $i++) {
        $reader->getLine();
    }

    $currentLineNumber = $reader->getCurrentLineNumber();

    expect($currentLineNumber)->toBeInt()->toEqual(5);
});

test('gives correct line number: end', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);

    for ($i = 0; $i < 9; $i++) {
        $reader->getLine();
    }

    $currentLineNumber = $reader->getCurrentLineNumber();

    expect($currentLineNumber)->toBeInt()->toEqual(10);
});

test('reads until', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);

    $lines = $reader->getLinesUntil('Line 3');

    expect($lines)->toBeString()->toEqual("Line 1\nLine 2\nLine 3\n");
});

test('reads until: not found', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);

    $lines = $reader->getLinesUntil('Line 15');

    expect($lines)->toBeNull();
});

test('reads line', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);

    $lines = $reader->getLine();

    expect($lines)->toBeString()->toEqual("Line 1\n");
});

test('seeks: start', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(1);

    $currentLineNumber = $reader->getCurrentLineNumber();

    expect($currentLineNumber)->toBeInt()->toEqual(1);
});

test('seeks and reads: start', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(1);

    $currentLineNumber = $reader->getCurrentLineNumber();
    $line = $reader->getLine();

    expect($currentLineNumber)->toBeInt()->toEqual(1)
        ->and($line)->toBeString()->toEqual("Line 1\n");
});

test('seeks: inside', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(5);

    $currentLineNumber = $reader->getCurrentLineNumber();

    expect($currentLineNumber)->toBeInt()->toEqual(5);
});

test('seeks and reads: inside', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(5);

    $currentLineNumber = $reader->getCurrentLineNumber();
    $line = $reader->getLine();

    expect($currentLineNumber)->toBeInt()->toEqual(5)
        ->and($line)->toBeString()->toEqual("Line 5\n");
});

test('seeks: end', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(10);

    $currentLineNumber = $reader->getCurrentLineNumber();

    expect($currentLineNumber)->toBeInt()->toEqual(10);
});

test('seeks and reads: end', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(10);

    $currentLineNumber = $reader->getCurrentLineNumber();
    $line = $reader->getLine();

    expect($currentLineNumber)->toBeInt()->toEqual(10)
        ->and($line)->toBeString()->toEqual("Line 10\n");
});

test('fails seeking backwards', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(5);
    $reader->seek(4);

})->throws(ReaderSeekingOutOfRangeException::class, 'Seek target not reachable. Pointer: 5, Target: 4, EoF: 0');

test('fails seeking out-of-bounds', function () {
    $reader = new FileReader();

    $reader->openFile(READER_TEST_FILEPATH);
    $reader->seek(12);

})->throws(ReaderSeekingOutOfRangeException::class, 'Seek target not reachable. Pointer: 11, Target: 12, EoF: 1');
