<?php

/**
 * This file contains the DeliveryApiGetEntriesTest class.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Requests_Exception_HTTP_400;
use Requests_Exception;

/**
 * This class contains the tests for the DeliveryApi.
 *
 * @covers Lunr\Spark\Contentful\DeliveryApi
 */
class DeliveryApiGetEntriesTest extends DeliveryApiTest
{

    /**
     * Test that get_entries() returns an empty result if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithoutFiltersReturnsEmptyResultOnRequestError(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/entries';
        $params = [ 'access_token' => 'token', 'content_type' => 'foo' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400(NULL, $this->response)));

        $this->response->status_code = 400;
        $this->response->url         = 'https://cdn.contentful.com/entries';

        $body = [
            'message' => 'Some error',
            'sys'     => [
                'id' => 'Some ID',
            ],
        ];

        $this->response->body = json_encode($body);

        $context = [
            'message' => 'Some error',
            'request' => 'https://cdn.contentful.com/entries',
            'id'      => 'Some ID',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Contentful API Request ({request}) failed with id "{id}": {message}', $context);

        $return = $this->class->get_entries('foo');

        $this->assertIsArray($return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_entries() returns an empty result if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithFiltersReturnsEmptyResultOnRequestError(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/entries';
        $params = [ 'field.urlName[match]' => 'bar', 'access_token' => 'token', 'content_type' => 'foo' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400(NULL, $this->response)));

        $this->response->status_code = 400;
        $this->response->url         = 'https://cdn.contentful.com/entries';

        $body = [
            'message' => 'Some error',
            'sys'     => [
                'id' => 'Some ID',
            ],
        ];

        $this->response->body = json_encode($body);

        $context = [
            'message' => 'Some error',
            'request' => 'https://cdn.contentful.com/entries',
            'id'      => 'Some ID',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Contentful API Request ({request}) failed with id "{id}": {message}', $context);

        $return = $this->class->get_entries('foo', [ 'field.urlName[match]' => 'bar' ]);

        $this->assertIsArray($return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_entries() returns an empty result if the request failed.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithoutFiltersReturnsEmptyResultOnRequestFailure(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/entries';
        $params = [ 'access_token' => 'token', 'content_type' => 'foo' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->throwException(new Requests_Exception('cURL error 0001: Network error', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $this->response->url = 'https://cdn.contentful.com/entries';

        $context = [
            'message' => 'cURL error 0001: Network error',
            'request' => 'https://cdn.contentful.com/entries',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Contentful API Request ({request}) failed! {message}', $context);

        $return = $this->class->get_entries('foo');

        $this->assertIsArray($return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_entries() returns an empty result if the request failed.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithFiltersReturnsEmptyResultOnRequestFailure(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/entries';
        $params = [ 'field.urlName[match]' => 'bar', 'access_token' => 'token', 'content_type' => 'foo' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->throwException(new Requests_Exception('cURL error 0001: Network error', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $this->response->url = 'https://cdn.contentful.com/entries';

        $context = [
            'message' => 'cURL error 0001: Network error',
            'request' => 'https://cdn.contentful.com/entries',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Contentful API Request ({request}) failed! {message}', $context);

        $return = $this->class->get_entries('foo', [ 'field.urlName[match]' => 'bar' ]);

        $this->assertIsArray($return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_entries() returns the request result on success.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithoutFiltersReturnsResultsOnSuccessfulRequest(): void
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/entries';
        $params = [ 'access_token' => 'token', 'content_type' => 'foo' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);

        $result = $this->class->get_entries('foo');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $result);
    }

    /**
     * Test that get_entries() returns the request result on success.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithFiltersReturnsResultsOnSuccessfulRequest(): void
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/entries';
        $params = [ 'field.urlName[match]' => 'bar', 'access_token' => 'token', 'content_type' => 'foo' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);

        $result = $this->class->get_entries('foo', [ 'field.urlName[match]' => 'bar' ]);

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $result);
    }

}

?>
