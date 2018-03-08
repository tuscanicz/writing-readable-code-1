<?php

declare(strict_types=1);

namespace Wrc\Api;

class ForeignApiHandler
{
    /**
     * @param string $url
     * @throws UnableToGetContentException
     * @return Result
     */
    public function handleReadable(string $url): Result
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_HEADER, false);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_REFERER, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_TIMEOUT, 10);
        $content = curl_exec($handle);
        $curlError = curl_error($handle);
        curl_close($handle);

        if ($content === false) {
            throw new UnableToGetContentException(
                $url,
                sprintf('Getting content from %s failed with error: %s', $url, $curlError)
            );
        }

        return new Result(
            (string) $content
        );
    }

    /**
     * @param string $url
     * @return array
     */
    public function handleMessy(string $url): array
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_HEADER, false);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_REFERER, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_TIMEOUT, 10);
        $content = curl_exec($handle);
        $curlError = curl_error($handle);
        curl_close($handle);

        if ($content === false) {
            return [
                'result' => null,
                'error' => $curlError
            ];
        }

        return [
            'result' => (string) $content
        ];
    }
}
