<?php

/**
 * This file contains the CliRequestParserTest class.
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\CliRequestParser;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the CliRequestParser class.
 *
 * @covers Lunr\Shadow\CliRequestParser
 */
abstract class CliRequestParserTest extends LunrBaseTest
{

    /**
     * Mock of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the Header class
     * @var \http\Header
     */
    protected $header;

    /**
     * Shared TestCase Constructor code.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $ast = [
            'f'        => [ 'value for f' ],
            'w'        => [],
            'a'        => [],
            'required' => [ [ 'value1', 'value2', 'value3' ] ],
            'optional' => [ 'optional value' ],
            'option'   => [],
        ];

        $parser = $this->getMockBuilder('Lunr\Shadow\CliParserInterface')->getMock();

        $parser->expects($this->any())
               ->method('parse')
               ->will($this->returnValue($ast));

        $this->header = $this->getMockBuilder('http\Header')->getMock();

        $this->class      = new CliRequestParser($this->configuration, $parser, $this->header);
        $this->reflection = new ReflectionClass('Lunr\Shadow\CliRequestParser');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->configuration);
        unset($this->header);
    }

    /**
     * Unit Test Data Provider for invalid super global values.
     *
     * @return array $cookie Set of invalid super global values
     */
    public function invalidSuperglobalValueProvider(): array
    {
        $values   = [];
        $values[] = [ [] ];
        $values[] = [ 0 ];
        $values[] = [ 'String' ];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];

        return $values;
    }

    /**
     * Unit Test Data Provider for Accept header content type(s).
     *
     * @return array $value Array of content type(s)
     */
    public function contentTypeProvider(): array
    {
        $value   = [];
        $value[] = [ 'text/html' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header language(s).
     *
     * @return array $value Array of language(s)
     */
    public function acceptLanguageProvider(): array
    {
        $value   = [];
        $value[] = [ 'en-US' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header charset(s).
     *
     * @return array $value Array of charset(s)
     */
    public function acceptCharsetProvider(): array
    {
        $value   = [];
        $value[] = [ 'utf-8' ];

        return $value;
    }

}

?>
