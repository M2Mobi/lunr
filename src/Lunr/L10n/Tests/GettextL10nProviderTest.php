<?php

/**
 * This file contains the GettextL10nProviderTest class.
 *
 * @package    Lunr\L10n
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\GettextL10nProvider;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GettextL10nProvider class.
 *
 * @covers Lunr\L10n\GettextL10nProvider
 */
abstract class GettextL10nProviderTest extends LunrBaseTest
{

    /**
     * Mock Object for a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * The language used for testing.
     * @var String
     */
    const LANGUAGE = 'de_DE';

    /**
     * The domain used for testing.
     * @var String
     */
    const DOMAIN = 'Lunr';

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->class = new GettextL10nProvider(self::LANGUAGE, self::DOMAIN, $this->logger);
        $this->class->set_default_language('nl_NL');
        $this->class->set_locales_location(TEST_STATICS . '/l10n');

        $this->reflection = new ReflectionClass('Lunr\L10n\GettextL10nProvider');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
    }

}

?>
