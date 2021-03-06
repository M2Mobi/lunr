<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectCSVTest class.
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;
use stdClass;

/**
 * This class contains tests for the put_csv_file_content method in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectCSVTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that put_csv_file_content() logs a warning when cannot open the given file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentCannotOpenFile(): void
    {
        $this->mock_function('fopen', function (){return FALSE;});

        $this->logger->expects($this->once())
             ->method('warning')
             ->with($this->equalTo('Could not open the file: filepath'));

        $this->assertFalse($this->class->put_csv_file_content('filepath', [ [ 'value1', 'value2' ] ]));

        $this->unmock_function('fopen');
    }

    /**
     * Test that put_csv_file_content() creates an empty file in invalid array values.
     *
     * @param mixed $values Invalid values
     *
     * @dataProvider invalidCSVArrayValuesProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentInInvalidArrayValues($values): void
    {
        $filepath = TEST_STATICS . '/Gravity/folder2/test.csv';

        $this->assertTrue($this->class->put_csv_file_content($filepath, [ [ $values ] ]));
        $this->assertStringMatchesFormatFile($filepath, "\n");

        unlink($filepath);
    }

    /**
     * Test that put_csv_file_content() returns TRUE in success.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentSuccess(): void
    {
        $filepath = TEST_STATICS . '/Gravity/folder2/test.csv';

        $this->assertTrue($this->class->put_csv_file_content($filepath, [ [ 'value1', 'value2' ] ]));
        $this->assertStringMatchesFormatFile($filepath, "value1,value2\n");

        unlink($filepath);
    }

    /**
     * Test that put_csv_file_content() returns TRUE in success with enclosure and delimeter.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentSuccessCustomDelimeter(): void
    {
        $filepath = TEST_STATICS . '/Gravity/folder2/test.csv';

        $this->assertTrue($this->class->put_csv_file_content($filepath, [ [ 'value1', 'value2' ] ], '-'));
        $this->assertStringMatchesFormatFile($filepath, "value1-value2\n");

        unlink($filepath);
    }

}

?>
