<?php


namespace Futape\Utility\Php;

use Futape\Utility\String\Strings;

abstract class Php
{
    const SHORT_NOTATION_SYMBOLS = [
        'k' => 1,
        'm' => 2,
        'g' => 3
    ];

    /**
     * Converts a shorthand byte value to bytes
     *
     * Processes shorthand byte values as described in PHP's FAQ to bytes.
     *
     * Ths function provides a few extras:
     *
     * + If an invalid symbol or none at all is given, the amount is simply multiplied by 1
     * + If the amount is missing, 1 is multiplied by the symbol instead (if present and valid, otherwise 0)
     * + The symbol is treated case-insensitively
     * + A negative amount is supported
     *
     * @see http://php.net/manual/en/faq.using.php#faq.using.shorthandbytes
     * @see self::SHORT_NOTATION_SYMBOLS
     *
     * @param string $short
     * @return int
     */
    public static function shortNotationToBytes(string $short): int
    {
        $matches = [];

        preg_match('/^(?:-?\d+)?/', $short, $matches);

        $amount = $matches[0];
        $symbol = mb_strtolower(Strings::stripLeft($short, $amount));

        if (!isset(self::SHORT_NOTATION_SYMBOLS[$symbol])) {
            return (int)$amount;
        }

        $amount = $amount == '' ? 1 : (int)$amount;
        $bytes = $amount * pow(1024, self::SHORT_NOTATION_SYMBOLS[$symbol]);

        return $bytes;
    }
}
