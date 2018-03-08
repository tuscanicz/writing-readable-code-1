<?php

declare(strict_types=1);

namespace Wrc\Api;

use Exception;
use Throwable;

class UnableToGetContentException extends Exception
{
    private $url;

    public function __construct(string $url, string $message, ?Throwable $previous = null)
    {
        $this->url = $url;
        parent::__construct($message, 0, $previous);
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
