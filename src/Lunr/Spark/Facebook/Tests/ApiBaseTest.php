<?php

/**
 * This file contains the ApiBaseTest class.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Facebook\Api
 */
class ApiBaseTest extends ApiTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the CentralAuthenticationStore class is passed correctly.
     */
    public function testCasIsSetCorrectly(): void
    {
        $this->assertPropertySame('cas', $this->cas);
    }

    /**
     * Test that the Requests_Session class is passed correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertPropertySame('http', $this->http);
    }

    /**
     * Test that fields is empty.
     */
    public function testFieldsIsEmptyByDefault(): void
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('fields'));
    }

    /**
     * Test that data is empty.
     */
    public function testDataIsEmptyByDefault(): void
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that used_access_token is FALSE.
     */
    public function testUsedAccessTokenIsFalseByDefault(): void
    {
        $this->assertFalse($this->get_reflection_property_value('used_access_token'));
    }

    /**
     * Test that the default resource ID is an empty String.
     */
    public function testIDIsEmptyString(): void
    {
        $this->assertPropertySame('id', '');
    }

    /**
     * Test that __get() gets existing credential values from the CAS.
     *
     * @param string $key Credential key
     *
     * @dataProvider generalGetKeyProvider
     * @covers       Lunr\Spark\Facebook\Api::__get
     */
    public function testGetExistingCredentials($key): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo($key))
                  ->will($this->returnValue('value'));

        $this->assertEquals('value', $this->class->{$key});
    }

    /**
     * Test that __get() returns NULL for non-existing credential keys.
     *
     * @covers Lunr\Spark\Facebook\Api::__get
     */
    public function testGetNonExistingCredentials(): void
    {
        $this->cas->expects($this->never())
                  ->method('get');

        $this->assertNull($this->class->invalid);
    }

    /**
     * Test that __set() sets general credential values in the CAS.
     *
     * @param string $key Credential key
     *
     * @dataProvider generalSetKeyProvider
     * @covers       Lunr\Spark\Facebook\Api::__set
     */
    public function testSetGeneralCredentials($key): void
    {
        $this->cas->expects($this->once())
                  ->method('add')
                  ->with($this->equalTo('facebook'), $this->equalTo($key), $this->equalTo('value'));

        $this->class->{$key} = 'value';
    }

    /**
     * Test that __set() sets access token value in the CAS.
     *
     * @covers Lunr\Spark\Facebook\Api::__set
     */
    public function testSetAccessTokenSetsAccessToken(): void
    {
        $this->cas->expects($this->at(0))
                  ->method('add')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'), $this->equalTo('value'));

        $this->class->access_token = 'value';
    }

    /**
     * Test that __set() sets app secret proof value in the CAS when setting the access token.
     *
     * @covers Lunr\Spark\Facebook\Api::__set
     */
    public function testSetAccessTokenSetsAppSecretProof(): void
    {
        $proof = hash_hmac('sha256', 'value', 'app_secret');

        $this->cas->expects($this->at(2))
                  ->method('add')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret_proof'), $this->equalTo($proof));

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('app_secret'));

        $this->class->access_token = 'value';
    }

    /**
     * Test that setting an invalid key does not touch the CAS.
     *
     * @covers Lunr\Spark\Facebook\Api::__set
     */
    public function testSetInvalidKeyDoesNotAlterCAS(): void
    {
        $this->cas->expects($this->never())
                  ->method('add');

        $this->class->invalid = 'value';
    }

    /**
     * Test that set_id() sets the resource ID.
     *
     * @covers Lunr\Spark\Facebook\Api::set_id
     */
    public function testSetIdSetsResourceId(): void
    {
        $this->class->set_id('Lunr');

        $this->assertPropertyEquals('id', 'Lunr');
    }

    /**
     * Test that set_fields() sets fields if given an array.
     *
     * @covers Lunr\Spark\Facebook\Api::set_fields
     */
    public function testSetFieldsWithArraySetsFields(): void
    {
        $fields = [ 'email', 'first_name' ];

        $this->class->set_fields($fields);

        $this->assertPropertySame('fields', $fields);
    }

    /**
     * Test that set_fields() does not set fields if not given an array.
     *
     * @param mixed $value Non array value
     *
     * @dataProvider nonArrayProvider
     * @covers       Lunr\Spark\Facebook\Api::set_fields
     */
    public function testSetFieldsWithNonArrayDoesNotSetFields($value): void
    {
        $this->class->set_fields($value);

        $this->assertArrayEmpty($this->get_reflection_property_value('fields'));
    }

}

?>
