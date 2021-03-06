<?php

/**
 * This file contains the L10nTraitTest class.
 *
 * @package    Lunr\L10n
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10nTrait;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the L10n class.
 *
 * @covers Lunr\L10n\L10nTrait
 */
class L10nTraitTest extends LunrBaseTest
{

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * The language used for testing.
     * @var String
     */
    const LANGUAGE = 'de_DE';

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->class      = $this->getObjectForTrait('Lunr\L10n\L10nTrait');
        $this->reflection = new ReflectionClass($this->class);
        $this->logger     = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->set_reflection_property_value('logger', $this->logger);
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
    }

}

?>
