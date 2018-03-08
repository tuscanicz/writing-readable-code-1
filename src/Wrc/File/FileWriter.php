<?php

declare(strict_types=1);

namespace Wrc\File;

class FileWriter
{
    /**
     * @param string $filePath
     * @param string $fileContents
     * @throws UnableToWriteFileException
     */
    public function writeFile(string $filePath, string $fileContents): void
    {
        $fileWriteResult = @file_put_contents(
            $filePath,
            $fileContents
        );
        if ($fileWriteResult === 0) {
            throw new UnableToWriteFileException(
                'Could not write empty file into path: ' . $filePath
            );
        }
        if ($fileWriteResult === null || $fileWriteResult === false) {
            throw new UnableToWriteFileException(
                'Could not write into path: ' . $filePath
            );
        }
    }
}
