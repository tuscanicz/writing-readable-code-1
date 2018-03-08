<?php

declare(strict_types=1);

namespace Wrc\Command;

use InvalidArgumentException;

class Address
{
    private $url;

    public function __construct(string $url)
    {
        $parsedUrl = parse_url($url);
        if ($parsedUrl === false) {
            throw new InvalidArgumentException(
                'Invalid url given: ' . $url
            );
        }
        if ($parsedUrl['scheme'] === null) {
            throw new InvalidArgumentException(
                'Invalid url given, no scheme specified: ' . $url
            );
        }
        if ($parsedUrl['host'] === null) {
            throw new InvalidArgumentException(
                'Invalid url given, no host specified: ' . $url
            );
        }
        if ($parsedUrl['port'] === null) {
            throw new InvalidArgumentException(
                'Invalid url given, no port specified: ' . $url
            );
        }
        $normalizedUrl = sprintf(
            '%s://%s:%d',
            $parsedUrl['scheme'],
            $parsedUrl['host'],
            $parsedUrl['port']
        );
        if (array_key_exists('path', $parsedUrl) === true) {
            $normalizedUrl .= $parsedUrl['path'];
        }
        $this->url = $normalizedUrl;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
