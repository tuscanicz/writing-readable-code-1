<?php

declare(strict_types=1);

namespace Wrc\Api;

class Result
{
    private $contents;

    public function __construct(string $contents)
    {
        $this->contents = $contents;
    }

    public function getContents(): string
    {
        return $this->contents;
    }
}
