<?php

namespace src;

class Formatter
{

    /**
     * @param string $text
     * @return string
     * @throws \Exception
     */
    public static function common(string $text) : string
    {
        $text = mb_convert_encoding($text, "utf-8", "windows-1251");
        $text = preg_replace('/(From): .* (\W\w+@\w+\W)/', '$1: $2', $text);
        $text = preg_replace('/(To): .* (\W\w+@\w+\W)/', '$1: $2', $text);
        $text = preg_replace('/>/', '', $text);
        $text = mb_strtolower($text);

        $lines = [];
        foreach (explode(PHP_EOL, $text) as $line) {

            if(0 === preg_match('/[0-9a-zA-ZA-Яа-я]/', $line)) {
                continue;
            }

            $lines[] =  trim($line);
        }

        return implode(' ', $lines);

    }

    /**
     * @param string $text
     * @return string
     */
    public static function phone(string $text) : string
    {
        $text = self::common($text);
        $text = preg_replace('/[+\(\)-]/', '', $text);
        $text = preg_replace('/(\d)\s(\d)/', '$1$2', $text);
        $text = preg_replace('/([=\+.\!?])(\d)/', '$1 $2', $text);
        return preg_replace('/(\d)([=\+.\!?])/', '$1 $2', $text);
    }
}
