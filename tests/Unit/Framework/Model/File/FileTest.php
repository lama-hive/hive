<?php

declare(strict_types=1);

use Lamahive\Hive\Framework\Filesystem\File;

const FILE_TEST_FILEPATH = __DIR__ . '/test';

test('loads file', function () {
    $file = new File(FILE_TEST_FILEPATH);

    expect($file)->toBeObject();
});

test('reads line', function () {
    $file = new File(FILE_TEST_FILEPATH);

    $line = $file->getLine();
    expect($line)->toBeString()->toEqual("Line 1\n");
});

test('reads null on file end', function () {
    $file = new File(FILE_TEST_FILEPATH);

    for ($i = 0; $i < 11; $i++) {
        $line = $file->getLine();
    }

    expect($line)->toBeNull();
});
