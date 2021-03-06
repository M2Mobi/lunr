<?php

/**
 * This file contains the DateTimeGetDelayedTimestampTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\DateTime;

/**
 * This class contains the tests for the get_delayed_timestamp() method
 *
 * @covers     Lunr\Core\DateTime
 */
class DateTimeGetDelayedTimestampTest extends DateTimeTest
{

    /**
     * Test get_delayed_timestamp() with the current timestamp as base.
     *
     * @covers Lunr\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCurrentTimestampAsBase(): void
    {
        $this->assertEquals(strtotime('+1 day'), $this->class->get_delayed_timestamp('+1 day'));
    }

    /**
     * Test get_delayed_timestamp() with a custom timestamp as base.
     *
     * @param integer $base UNIX Timestamp
     *
     * @dataProvider validTimestampProvider
     * @covers       Lunr\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCustomTimestampAsBase($base): void
    {
        $this->assertEquals(strtotime('+1 day', $base), $this->class->get_delayed_timestamp('+1 day', $base));
    }

    /**
     * Test get_delayed_timestamp() with a custom but invalid timestamp as base.
     *
     * @param mixed $base Various invalid timestamp values
     *
     * @dataProvider invalidTimestampProvider
     * @covers       Lunr\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCustomInvalidTimestampAsBase($base): void
    {
        $this->assertFalse($this->class->get_delayed_timestamp('+1 day', $base));
    }

    /**
     * Test get_delayed_timestamp() with a valid delay and current timestamp as base.
     *
     * @param string $delay Various valid delay definitions
     *
     * @dataProvider validDelayProvider
     * @covers       Lunr\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithValidDelay($delay): void
    {
        $this->assertEquals(strtotime($delay), $this->class->get_delayed_timestamp($delay));
    }

    /**
     * Test get_delayed_timestamp() with an invalid delay and current timestamp as base.
     *
     * @param mixed $delay Various invalid delay definitions
     *
     * @dataProvider invalidDelayProvider
     * @covers       Lunr\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithInvalidDelay($delay): void
    {
        $this->assertFalse($this->class->get_delayed_timestamp($delay));
    }

}

?>
