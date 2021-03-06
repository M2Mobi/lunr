<?php

/**
 * This file contains low level API methods for Facebook.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook;

use Requests_Exception;
use Requests_Exception_HTTP;

/**
 * Low level Facebook API methods for Spark
 */
abstract class Api
{

    /**
     * Shared instance of the CentralAuthenticationStore
     * @var \Lunr\Spark\CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Shared instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Requested fields of the profile.
     * @var Array
     */
    protected $fields;

    /**
     * Facebook resource identifier
     * @var String
     */
    protected $id;

    /**
     * Returned data.
     * @var Array
     */
    protected $data;

    /**
     * Boolean flag whether an access token was used for the request.
     * @var Boolean
     */
    protected $used_access_token;

    /**
     * Constructor.
     *
     * @param \Lunr\Spark\CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param \Psr\Log\LoggerInterface               $logger Shared instance of a Logger class.
     * @param \Requests_Session                      $http   Shared instance of the Requests_Session class.
     */
    public function __construct($cas, $logger, $http)
    {
        $this->cas    = $cas;
        $this->logger = $logger;
        $this->http   = $http;
        $this->id     = '';
        $this->fields = [];
        $this->data   = [];

        $this->used_access_token = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
        unset($this->logger);
        unset($this->http);
        unset($this->id);
        unset($this->fields);
        unset($this->data);
        unset($this->used_access_token);
    }

    /**
     * Get access to shared credentials.
     *
     * @param string $key Credentials key
     *
     * @return mixed $return Value of the chosen key
     */
    public function __get($key)
    {
        switch ($key)
        {
            case 'app_id':
            case 'app_secret':
            case 'app_secret_proof':
            case 'access_token':
                return $this->cas->get('facebook', $key);
            default:
                return NULL;
        }
    }

    /**
     * Set shared credentials.
     *
     * @param string $key   Key name
     * @param string $value Value to set
     *
     * @return void
     */
    public function __set($key, $value)
    {
        switch ($key)
        {
            case 'app_id':
            case 'app_secret':
                $this->cas->add('facebook', $key, $value);
                break;
            case 'access_token':
                $this->cas->add('facebook', $key, $value);
                $this->cas->add('facebook', 'app_secret_proof', hash_hmac('sha256', $value, $this->app_secret));
                break;
            default:
                break;
        }
    }

    /**
     * Set the resource ID.
     *
     * @param string $id Facebook resource ID
     *
     * @return void
     */
    public function set_id($id)
    {
        $this->id = $id;
    }

    /**
     * Specify the user profile fields that should be retrieved.
     *
     * @param array $fields Fields to retrieve
     *
     * @return void
     */
    public function set_fields($fields)
    {
        if (is_array($fields) === FALSE)
        {
            return;
        }

        $this->fields = $fields;
    }

    /**
     * Fetch and parse results as though they were a query string.
     *
     * @param string $url    API URL
     * @param array  $params Array of parameters for the API request
     * @param string $method Request method to use, either 'get' or 'post'
     *
     * @return array $parts Array of return values
     */
    protected function get_url_results($url, $params = [], $method = 'get')
    {
        $method = strtoupper($method);

        $parts = [];

        try
        {
            $response = $this->http->request($url, [], $params, $method);

            parse_str($response->body, $parts);

            $response->throw_for_status();
        }
        catch (Requests_Exception_HTTP $e)
        {
            $parts   = [];
            $message = json_decode($response->body, TRUE);
            $error   = $message['error'];
            $context = [ 'message' => $error['message'], 'code' => $error['code'], 'type' => $error['type'], 'request' => $response->url ];

            $this->logger->warning('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);
        }
        catch (Requests_Exception $e)
        {
            $context = [ 'message' => $e->getMessage(), 'request' => $url ];

            $this->logger->warning('Facebook API Request ({request}) failed: {message}', $context);
        }

        unset($response);

        return $parts;
    }

    /**
     * Fetch and parse results as though they were a query string.
     *
     * @param string $url    API URL
     * @param array  $params Array of parameters for the API request
     * @param string $method Request method to use, either 'get' or 'post'
     *
     * @return array $parts Array of return values
     */
    protected function get_json_results($url, $params = [], $method = 'get')
    {
        $method = strtoupper($method);

        $result = [];

        try
        {
            $response = $this->http->request($url, [], $params, $method);

            $result = json_decode($response->body, TRUE);

            $response->throw_for_status();
        }
        catch (Requests_Exception_HTTP $e)
        {
            $error   = $result['error'];
            $result  = [];
            $context = [ 'message' => $error['message'], 'code' => $error['code'], 'type' => $error['type'], 'request' => $response->url ];

            $this->logger->warning('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);
        }
        catch (Requests_Exception $e)
        {
            $context = [ 'message' => $e->getMessage(), 'request' => $url ];

            $this->logger->warning('Facebook API Request ({request}) failed: {message}', $context);
        }

        unset($response);

        return $result;
    }

    /**
     * Fetch the resource information from Facebook.
     *
     * @param string $url    API URL
     * @param array  $params Array of parameters for the API request
     *
     * @return void
     */
    protected function fetch_data($url, $params = [])
    {
        if ($this->access_token !== NULL)
        {
            $params['access_token']    = $this->access_token;
            $params['appsecret_proof'] = $this->app_secret_proof;

            $this->used_access_token = TRUE;
        }
        else
        {
            $this->used_access_token = FALSE;
        }

        if (empty($this->fields) === FALSE)
        {
            $params['fields'] = implode(',', $this->fields);
        }

        $this->data = $this->get_json_results($url, $params);
    }

}

?>
