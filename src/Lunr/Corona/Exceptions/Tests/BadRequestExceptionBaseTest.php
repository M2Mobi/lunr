<?php

/**
 * This file contains the BadRequestExceptionBaseTest class.
 *
 * @package Lunr\Corona\Exceptions
 * @author  Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Corona\Exceptions\Tests;

use Lunr\Corona\Exceptions\Tests\Helpers\HttpExceptionTest;
use Exception;

/**
 * This class contains tests for the BadRequestException class.
 *
 * @covers Lunr\Corona\Exceptions\BadRequestException
 */
class BadRequestExceptionBaseTest extends HttpExceptionTest
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('code', 400);
    }

    /**
     * Test that the error code was set correctly.
     */
    public function testApplicationErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('app_code', $this->code);
    }

    /**
     * Test that the input data key was set correctly.
     */
    public function testInputDataKeyIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('key'));
    }

    /**
     * Test that the input data value was set correctly.
     */
    public function testInputDataValueIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('value'));
    }

    /**
     * Test that the input data flag was set correctly.
     */
    public function testInputDataAvailableIsFalse(): void
    {
        $this->assertFalse($this->get_reflection_property_value('dataAvailable'));
    }

    /**
     * Test that the error message was passed correctly.
     */
    public function testErrorMessagePassedCorrectly(): void
    {
        $this->expectExceptionMessage($this->message);

        throw $this->class;
    }

}

?>
