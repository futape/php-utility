<?php


use Futape\Utility\Php\Php;
use PHPUnit\Framework\Exception;
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

    /**
     * @dataProvider assertIniDataProvider
     *
     * @param string $option
     * @param string $setUpValue
     * @param $assertValue
     *
     * @throws Exception
     */
    public function testAssertIni(string $option, string $setUpValue, $assertValue)
    {
        $this->iniSet($option, $setUpValue);
        $this->assertTrue(Php::assertIni($option, $assertValue));
    }

    public function assertIniDataProvider(): array
    {
        return [
            'Assert string value' => ['user_agent', 'curl/7.65.1', 'curl/7.65.1'],
            'Assert true (1)' => ['display_errors', '1', true],
            'Assert true (on)' => ['display_errors', 'On', true],
            'Assert false (0)' => ['display_errors', '0', false],
            'Assert false (off)' => ['display_errors', 'Off', false],
            'Assert false (empty string)' => ['display_errors', '', false]
        ];
    }

    public function testAssertIniNull()
    {
        $this->iniSet('error_append_string', 'foobar');
        ini_restore('error_append_string');
        $this->assertTrue(Php::assertIni('error_append_string', null));
    }

    public function testAssertIniInvalidOption()
    {
        $this->assertNull(Php::assertIni('foobar', null));
    }

    public function testAssertIniInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        Php::assertIni('user_agent', 1);
    }
}
