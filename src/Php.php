<?php


namespace Futape\Utility\Php;

use Futape\Utility\String\Strings;
use InvalidArgumentException;

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

    /**
     * Asserts the value of an INI option
     *
     * If a boolean arguments is passed to $expected, the INI value is asserted to be "0", "Off" (case-insensitive)
     * or an empty string for `false`, or "1" or "On" (case-insensitive) for `true`.
     * Expecting `null`, asserts the INI value to be an empty string and string arguments for $expected are
     * just compared to the plain INI value.
     * `null` is returned if the option doesn't exist.
     *
     * @param string $option
     * @param bool|string|null $expected
     * @return bool|null
     *
     * @throws InvalidArgumentException If an invalid argument is passed to $expected
     */
    public static function assertIni(string $option, $expected): ?bool
    {
        $value = ini_get($option);

        if ($value === false) {
            return null;
        }

        if ($expected === false) {
            return $value == '' || $value == '0' || mb_strtolower($value) == 'off';
        }
        if ($expected === true) {
            return $value == '1' || mb_strtolower($value) == 'on';
        }
        if ($expected === null) {
            return $value == '';
        }
        if (is_string($expected)) {
            return $value == $expected;
        }

        throw new InvalidArgumentException(
            'Argument for $expected parameter needs to be boolean, string or null',
            1573396893
        );
    }
}
