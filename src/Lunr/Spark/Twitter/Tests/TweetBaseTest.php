<?php

/**
 * This file contains the TweetBaseTest class.
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

/**
 * This class contains the tests for the Tweet.
 *
 * @covers Lunr\Spark\Twitter\Tweet
 */
class TweetBaseTest extends TweetTest
{

    /**
     * Test that the data is initially empty.
     */
    public function testDataIsSetCorrectly(): void
    {
        $this->assertPropertyEmpty('data');
    }

    /**
     * Tests that set_data() sets the property data.
     *
     * @covers Lunr\Spark\Twitter\Tweet::set_data
     */
    public function testSetData(): void
    {
        $this->class->set_data([ 'test' ]);

        $this->assertPropertyEquals('data', [ 'test' ]);
    }

    /**
     * Test fluid interface of set_data().
     *
     * @covers Lunr\Spark\Twitter\Tweet::set_data
     */
    public function testSetDataReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_data([ 'data' ]));
    }

}

?>
