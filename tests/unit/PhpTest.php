<?php


use Futape\Utility\Php\Php;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Futape\Utility\Php\Php
 */
class PhpTest extends TestCase
{
    /**
     * @dataProvider shortNotationToBytesDataProvider
     *
     * @param array $input
     * @param int $expected
     */
    public function testShortNotationToBytes(array $input, int $expected)
    {
        $this->assertEquals($expected, Php::shortNotationToBytes(...$input));
    }

    public function shortNotationToBytesDataProvider(): array
    {
        return [
            'Amount greater 0, valid symbol' => [
                ['2k'],
                2048
            ],
            'Amount greater 0, invalid symbol' => [
                ['2z'],
                2
            ],
            'Amount greater 0, no symbol' => [
                ['2'],
                2
            ],
            'No amount, valid symbol' => [
                ['k'],
                1024
            ],
            'No amount, invalid symbol' => [
                ['z'],
                0
            ],
            'No amount, no symbol' => [
                [''],
                0
            ],
            'Amount equals 0' => [
                ['0k'],
                0
            ],
            'Negative amount' => [
                ['-2k'],
                -2048
            ],
            'Uppercase symbol' => [
                ['2K'],
                2048
            ]
        ];
    }
}
