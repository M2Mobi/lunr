<?php

/**
 * This file contains the Resque job dispatcher.
 *
 * @package    Lunr\Spawn
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn;

use \Resque;

/**
 * Resque job dispatcher class.
 */
class ResqueJobDispatcher implements JobDispatcherInterface
{

    /**
     * The Resque instance of this dispatcher.
     * @var Resque
     */
    protected $resque;

    /**
     * The ResqueScheduler instance of this dispatcher.
     * @var ResqueScheduler
     */
    protected $scheduler;

    /**
     * The token of the last enqueued job.
     * @var String
     */
    protected $token;

    /**
     * The queue(s) to enqueue in.
     * @var Array
     */
    protected $queue;

    /**
     * The status tracking ability of enqueued jobs.
     * @var String
     */
    protected $track_status;

    /**
     * Constructor.
     *
     * @param Resque          $resque    The Resque instance used by this dispatcher
     * @param ResqueScheduler $scheduler The ResqueScheduler instance used by this dispatcher
     */
    public function __construct($resque, $scheduler)
    {
        $this->resque       = $resque;
        $this->scheduler    = $scheduler;
        $this->token        = NULL;
        $this->queue        = [ 'default_queue' ];
        $this->track_status = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->resque);
        unset($this->scheduler);
        unset($this->token);
        unset($this->queue);
        unset($this->track_status);
    }

    /**
     * Enqueue a job in php-resque.
     *
     * It is possible to dispatch the same job into multiple queues, if
     * more than one queues are set.
     *
     * @param string $job  The job to execute
     * @param array  $args The arguments for the job execution
     *
     * @return void
     */
    public function dispatch($job, $args = NULL)
    {
        foreach ($this->queue as $queue)
        {
            $this->token = $this->resque->enqueue($queue, $job, $args, $this->track_status);
        }
    }

    /**
     * Enqueue a delayed job in php-resque.
     *
     * It is possible to dispatch the same job into multiple queues, if
     * more than one queues are set.
     *
     * @param integer $seconds Amount of seconds in the future
     * @param string  $job     The job to execute
     * @param array   $args    The arguments for the job execution
     *
     * @return void
     */
    public function dispatch_in($seconds, $job, $args = NULL)
    {
        foreach ($this->queue as $queue)
        {
            $this->scheduler->enqueueIn($seconds, $queue, $job, $args);
        }
    }

    /**
     * Enqueue a delayed job in php-resque.
     *
     * It is possible to dispatch the same job into multiple queues, if
     * more than one queues are set.
     *
     * @param DateTime|integer $time Timestamp or DateTime object of when the job should execute
     * @param string           $job  The job to execute
     * @param array            $args The arguments for the job execution
     *
     * @return void
     */
    public function dispatch_at($time, $job, $args = NULL)
    {
        foreach ($this->queue as $queue)
        {
            $this->scheduler->enqueueAt($time, $queue, $job, $args);
        }
    }

    /**
     * Returns the token of the last dispatched Resque job.
     *
     * @return string $token The token of the last enqueued job,
     *                       NULL if unproper argument supplied
     */
    public function get_job_id()
    {
        return $this->token;
    }

    /**
     * Sets the queue(s) to dispatch to for this dispatcher.
     *
     * @param mixed $queue The queue or the queues to set for this dispatcher.
     *
     * @return ResqueJobDispatcher $self Self-reference
     */
    public function set_queue($queue)
    {
        $error = [];

        if (is_string($queue))
        {
            $this->queue = [ $queue ];
        }
        elseif (is_array($queue))
        {
            $this->queue = [];
            foreach ($queue as $value)
            {
                if (is_string($value))
                {
                    $this->queue[] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * Sets whether the status of the dispatched job will be tracked.
     *
     * @param boolean $track_status The queue to set for this dispatcher
     *
     * @return ResqueJobDispatcher $self Self-reference
     */
    public function set_track_status($track_status)
    {
        if (is_bool($track_status))
        {
            $this->track_status = $track_status;
        }

        return $this;
    }

}

?>
