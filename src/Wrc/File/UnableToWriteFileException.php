<?php

declare(strict_types=1);

namespace Wrc\File;

use Exception;
use Throwable;

class UnableToWriteFileException extends Exception
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
