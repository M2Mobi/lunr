<?php

/**
 * This file contains the GetoptCliParserBaseTest class.
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains base test methods for the GetoptCliParser class.
 *
 * @covers Lunr\Shadow\GetoptCliParser
 */
class GetoptCliParserBaseTest extends GetoptCliParserTest
{

    /**
     * Test that the short options string is passed correctly.
     */
    public function testShortOptsIsPassedCorrectly(): void
    {
        $this->assertPropertyEquals('short', 'ab:c::');
    }

    /**
     * Test that the long options string is passed correctly.
     */
    public function testLongOptsIsPassedCorrectly(): void
    {
        $this->assertPropertyEquals('long', [ 'first', 'second:', 'third::' ]);
    }

    /**
     * Test that error is set to FALSE by default.
     */
    public function testErrorIsFalseByDefault(): void
    {
        $this->assertFalse($this->get_reflection_property_value('error'));
    }

    /**
     * Test that is_invalid_commandline() returns the value of error.
     *
     * @covers Lunr\Shadow\GetoptCliParser::is_invalid_commandline
     */
    public function testIsInvalidCommandLineReturnsError(): void
    {
        $this->assertPropertyEquals('error', $this->class->is_invalid_commandline());
    }

}

?>
