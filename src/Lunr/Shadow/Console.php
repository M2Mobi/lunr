<?php

/**
 * This file contains the Console class.
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow;

/**
 * The Console class provides function to immediatly
 * output strings. Though this is certainly not a usecase
 * restricted to the console environment, this is where
 * it's primary usecase lies.
 */
class Console
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Constructor.
     *
     * @param DateTime $datetime Instance of the DateTime class.
     */
    public function __construct($datetime)
    {
        $this->datetime = $datetime;
        $this->datetime->set_datetime_format('%Y-%m-%d %H:%M:%S');
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->datetime);
    }

    /**
     * Print given message immediatly.
     *
     * @param string $msg Message to print
     *
     * @return void
     */
    public function cli_print($msg)
    {
        echo $this->build_cli_output($msg);
    }

    /**
     * Print given message immediatly and break the line afterwards.
     *
     * @param string $msg Message to print
     *
     * @return void
     */
    public function cli_println($msg)
    {
        echo $this->build_cli_output($msg) . "\n";
    }

    /**
     * Generate a string to output.
     *
     * @param string $msg Message to print
     *
     * @return string $return Generated String
     */
    private function build_cli_output($msg)
    {
        return $this->datetime->get_datetime() . ': ' . $msg;
    }

    /**
     * Print status information ([ok] or [failed]).
     *
     * @param boolean $bool Whether to print a good or bad status
     *
     * @return void
     */
    public function cli_print_status($bool)
    {
        if ($bool === TRUE)
        {
            echo "[ok]\n";
        }
        else
        {
            echo "[failed]\n";
        }
    }

}

?>
