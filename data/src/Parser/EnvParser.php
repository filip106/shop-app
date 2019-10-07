<?php

namespace src\Parser;

/**
 * Class EnvParser
 * @package src\Parser
 */
abstract class EnvParser
{
    /**
     * @param string $path
     *
     * @return array
     */
    public static function parseFile(string $path)
    {
        $data = explode("\n", str_replace(["\r\n", "\r"], "\n", file_get_contents($path)));

        $parsedData = [];

        foreach ($data as $keyValuePair) {
            list($key, $value) = explode('=', $keyValuePair);
            $parsedData[$key] = $value;
        }

        return $parsedData;
    }
}