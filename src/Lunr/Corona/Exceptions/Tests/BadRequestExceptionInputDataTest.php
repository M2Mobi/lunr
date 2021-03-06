<?php

/**
 * This file contains the BadRequestExceptionInputDataTest class.
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
class BadRequestExceptionInputDataTest extends HttpExceptionTest
{

    /**
     * Test that setData() sets the data correctly.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::setData
     */
    public function testSetDataSetsData(): void
    {
        $this->class->setData('foo', 'bar');

        $this->assertPropertyEquals('key', 'foo');
        $this->assertPropertyEquals('value', 'bar');
        $this->assertTrue($this->get_reflection_property_value('dataAvailable'));
    }

    /**
     * Test that setReport() sets the report correctly.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::setReport
     */
    public function testSetReportSetsReport(): void
    {
        $report = "Foo failed!\nBar failed!\n";

        $this->class->setReport($report);

        $this->assertPropertyEquals('report', $report);
        $this->assertTrue($this->get_reflection_property_value('reportAvailable'));
    }

    /**
     * Test that setReport() ignores an empty report.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::setReport
     */
    public function testSetReportDoesNotSetEmptyReport(): void
    {
        $report = "";

        $this->class->setReport($report);

        $this->assertPropertyEquals('report', NULL);
        $this->assertFalse($this->get_reflection_property_value('reportAvailable'));
    }

    /**
     * Test that setArrayReport() sets the report correctly.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::setArrayReport
     */
    public function testSetArrayReportSetsReport(): void
    {
        $failures = [
            'key1' => [
                'too long',
                'too big',
            ],
            'key2' => [
                'missing',
            ],
        ];

        $report = "key1: too long\nkey1: too big\nkey2: missing\n";

        $this->class->setArrayReport($failures);

        $this->assertPropertyEquals('report', $report);
        $this->assertTrue($this->get_reflection_property_value('reportAvailable'));
    }

    /**
     * Test that setArrayReport() ignores an empty report.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::setArrayReport
     */
    public function testSetArrayReportDoesNotSetEmptyReport(): void
    {
        $failures = [];

        $this->class->setArrayReport($failures);

        $this->assertPropertyEquals('report', NULL);
        $this->assertFalse($this->get_reflection_property_value('reportAvailable'));
    }

    /**
     * Test that getDataKey() returns the data key.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::getDataKey
     */
    public function testGetDataKey(): void
    {
        $this->set_reflection_property_value('key', 'foo');

        $this->assertEquals('foo', $this->class->getDataKey());
    }

    /**
     * Test that getDataValue() returns the data value.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::getDataValue
     */
    public function testGetDataValue(): void
    {
        $this->set_reflection_property_value('value', 'bar');

        $this->assertEquals('bar', $this->class->getDataValue());
    }

    /**
     * Test that getReport() returns the report.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::getReport
     */
    public function testGetReport(): void
    {
        $this->set_reflection_property_value('report', 'baz');

        $this->assertEquals('baz', $this->class->getReport());
    }

    /**
     * Test that isDataAvailable() returns whether input data was set.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::isDataAvailable
     */
    public function testIsDataAvailable(): void
    {
        $this->assertFalse($this->class->isDataAvailable());

        $this->set_reflection_property_value('dataAvailable', TRUE);

        $this->assertTrue($this->class->isDataAvailable());
    }

    /**
     * Test that isReportAvailable() returns whether a detailed report was set.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::isReportAvailable
     */
    public function testIsReportAvailable(): void
    {
        $this->assertFalse($this->class->isReportAvailable());

        $this->set_reflection_property_value('reportAvailable', TRUE);

        $this->assertTrue($this->class->isReportAvailable());
    }

}

?>
