<?php

use FsaMatch\FsaMatch;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    static $matcher;
    public static function setUpBeforeClass(): void
    {
        self::$matcher = new FsaMatch(__DIR__ . '/fixture.csv');
    }
    public function testBasicMatch()
    {
        self::$matcher = new FsaMatch(__DIR__ . '/fixture.csv');
        $match = self::$matcher->match('Abbots Arms', 'CH8 7BD');
        $this->assertNotEmpty($match);
    }

    public function testBasicNonMatch()
    {
        $match = self::$matcher->match('Something', 'CH8 LBD');
        $this->assertEmpty($match);
    }


    public function testPostCodeOnlyMatch()
    {
        $match = self::$matcher->match('Something', 'CH5 4JR');
        $this->assertNotEmpty($match);
        $this->assertSame('GT\'s Bar & Grill', $match['name']);
    }

    public function testSecondTimeFails()
    {

        $match = self::$matcher->match('Something', 'CH5 4JR');
        $this->assertEmpty($match);
    }

    public function testNonExactNameMatch()
    {

        $match = self::$matcher->match('KFC - QUEENSFERRY', 'CH5 1SX');
        $this->assertNotEmpty($match);
        $this->assertSame('KFC', $match['name']);
    }

    public function testLetterOnlyMatch()
    {
        $match = self::$matcher->match('CJs Cafe','CH5 2JZ');
        $this->assertNotEmpty($match);
        $this->assertSame('CJ\'s Cafe', $match['name']);
    }

    public function testPartialMatchOtherWay()
    {

        $match = self::$matcher->match('Kim\'s Kabin', 'CH4 8RH');
        $this->assertNotEmpty($match);
        $this->assertSame('Kim\'s Kabin Cafe', $match['name']);
    }
}
