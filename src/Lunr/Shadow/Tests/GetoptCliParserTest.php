<?php

/**
 * This file contains the GetoptCliParserTest class.
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\GetoptCliParser;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GetoptCliParser class.
 *
 * @covers Lunr\Shadow\GetoptCliParser
 */
abstract class GetoptCliParserTest extends LunrBaseTest
{

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->class      = new GetoptCliParser('ab:c::', [ 'first', 'second:', 'third::' ]);
        $this->reflection = new ReflectionClass('Lunr\Shadow\GetoptCliParser');
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for command line values.
     *
     * @return array $values Array of command line argument values.
     */
    public function valueProvider()
    {
        $values   = [];
        $values[] = [ 'string' ];
        $values[] = [ 1 ];
        $values[] = [ 1.1 ];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];

        return $values;
    }

}

?>
