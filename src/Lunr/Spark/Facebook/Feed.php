<?php

/**
 * This file contains Feeds support for Facebook.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook;

/**
 * Facebook Feeds Support for Spark
 */
class Feed extends User
{

    /**
     * Whether we fetched data from a user feed or not.
     * @var Boolean
     */
    protected $fetched_user_data;

    /**
     * Limit of posts to fetch from the feed.
     * @var Integer
     */
    protected $limit;

    /**
     * Timestamp for pagination
     * @var Integer
     */
    protected $next;

    /**
     * Timestamp for pagination
     * @var Integer
     */
    protected $previous;

    /**
     * Constructor.
     *
     * @param \Lunr\Spark\CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param \Psr\Log\LoggerInterface               $logger Shared instance of a Logger class.
     * @param \Requests_Session                      $http   Shared instance of the Requests_Session class.
     */
    public function __construct($cas, $logger, $http)
    {
        parent::__construct($cas, $logger, $http);

        $this->limit    = 25;
        $this->next     = 0;
        $this->previous = 0;

        $this->fetched_user_data = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->limit);
        unset($this->next);
        unset($this->previous);
        unset($this->fetched_user_data);

        parent::__destruct();
    }

    /**
     * Set limit of posts to fetch from feed.
     *
     * @param integer $limit Limit of posts to fetch
     *
     * @return void
     */
    public function set_limit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Get the posts of the feed.
     *
     * @return array $posts Array of Facebook Post objects.
     */
    public function get_posts()
    {
        return $this->data;
    }

    /**
     * Fetch the page information from Facebook.
     *
     * @param boolean $userdata Whether to fetch from the user feed or not
     *
     * @return void
     */
    public function get_data($userdata = FALSE)
    {
        if (($userdata === FALSE) && ($this->id === ''))
        {
            return;
        }

        $params['limit'] = $this->limit;

        $this->fetched_user_data = $userdata;

        $id  = ($this->fetched_user_data === FALSE) ? $this->id : $this->profile_id;
        $url = Domain::GRAPH . $id . '/feed';

        $this->fetch_data($url, $params);
    }

    /**
     * Get next posts in the feed.
     *
     * @return void
     */
    public function get_next()
    {
        $params = [
            'limit' => $this->limit,
            'until' => $this->next,
        ];

        $id  = ($this->fetched_user_data === FALSE) ? $this->id : $this->profile_id;
        $url = Domain::GRAPH . $id . '/feed';

        $this->fetch_data($url, $params);
    }

    /**
     * Get previous posts in the feed.
     *
     * @return void
     */
    public function get_previous()
    {
        $params = [
            'limit' => $this->limit,
            'since' => $this->previous,
        ];

        $id  = ($this->fetched_user_data === FALSE) ? $this->id : $this->profile_id;
        $url = Domain::GRAPH . $id . '/feed';

        $this->fetch_data($url, $params);
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
        parent::fetch_data($url, $params);

        $this->get_permissions();

        $this->classify();
    }

    /**
     * Split data into separate classes.
     *
     * @return void
     */
    protected function classify()
    {
        $posts = [];

        if (array_key_exists('data', $this->data) === FALSE)
        {
            $this->data     = $posts;
            $this->next     = 0;
            $this->previous = 0;

            return;
        }

        $parse = NULL;

        foreach ([ 'next', 'previous' ] as $key)
        {
            if (isset($this->data['paging'][$key]) === FALSE)
            {
                continue;
            }

            $value = NULL;

            parse_str($this->data['paging'][$key], $value);

            $this->$key = (int) $value[($key === 'next') ? 'until' : 'since' ];
        }

        foreach ($this->data['data'] as $post)
        {
            $posts[] = (new Post($this->cas, $this->logger, $this->http))->set_data($post, $this->permissions, $this->used_access_token);
        }

        $this->data = $posts;
    }

}

?>
