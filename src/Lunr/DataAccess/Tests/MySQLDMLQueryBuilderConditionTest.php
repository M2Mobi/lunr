<?php

/**
 * This file contains the MySQLDMLQueryBuilderConditionTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * where/having statements.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderConditionTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on
     */
    public function testOnWithDefaultOperator()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on('left', 'right');

        $this->assertEquals('ON left = right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on
     */
    public function testOnWithCustomOperator()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on('left', 'right', '>');

        $this->assertEquals('ON left > right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the on method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::on
     */
    public function testOnReturnsSelfReference()
    {
        $return = $this->builder->on('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_like
     */
    public function testOnLike()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_like('left', 'right');

        $this->assertEquals('ON left LIKE right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_like
     */
    public function testOnNotLike()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_like('left', 'right', TRUE);

        $this->assertEquals('ON left NOT LIKE right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the on_like method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::on_like
     */
    public function testOnLikeReturnsSelfReference()
    {
        $return = $this->builder->on_like('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_in
     */
    public function testOnIn()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_in('left', 'right');

        $this->assertEquals('ON left IN right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_like
     */
    public function testOnNotIn()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_in('left', 'right', TRUE);

        $this->assertEquals('ON left NOT IN right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the on_in method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::on_in
     */
    public function testOnInReturnsSelfReference()
    {
        $return = $this->builder->on_in('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_between
     */
    public function testOnBetween()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_between('left', 'right');

        $this->assertEquals('ON left BETWEEN right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_between
     */
    public function testOnNotBetween()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_between('left', 'right', TRUE);

        $this->assertEquals('ON left NOT BETWEEN right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the on_between method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::on_between
     */
    public function testOnBetweenReturnsSelfReference()
    {
        $return = $this->builder->on_between('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }
    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_regexp
     */
    public function testOnRegexp()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_regexp('left', 'right');

        $this->assertEquals('ON left REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::on_regexp
     */
    public function testOnNotRegexp()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_regexp('left', 'right', TRUE);

        $this->assertEquals('ON left NOT REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the on_regexp method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::on_regexp
     */
    public function testOnRegexpReturnsSelfReference()
    {
        $return = $this->builder->on_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where
     */
    public function testWhereWithDefaultOperator()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where('left', 'right');

        $this->assertEquals('WHERE left = right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where
     */
    public function testWhereWithCustomOperator()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where('left', 'right', '>');

        $this->assertEquals('WHERE left > right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the where method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::where
     */
    public function testWhereReturnsSelfReference()
    {
        $return = $this->builder->where('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_like
     */
    public function testWhereLike()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_like('left', 'right');

        $this->assertEquals('WHERE left LIKE right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_like
     */
    public function testWhereNotLike()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_like('left', 'right', TRUE);

        $this->assertEquals('WHERE left NOT LIKE right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the where_like method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::where_like
     */
    public function testWhereLikeReturnsSelfReference()
    {
        $return = $this->builder->where_like('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_in
     */
    public function testWhereIn()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_in('left', 'right');

        $this->assertEquals('WHERE left IN right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_in
     */
    public function testWhereNotIn()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_in('left', 'right', TRUE);

        $this->assertEquals('WHERE left NOT IN right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the where_in method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::where_in
     */
    public function testWhereInReturnsSelfReference()
    {
        $return = $this->builder->where_in('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_between
     */
    public function testWhereBetween()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_between('left', 'right');

        $this->assertEquals('WHERE left BETWEEN right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_between
     */
    public function testWhereNotBetween()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_between('left', 'right', TRUE);

        $this->assertEquals('WHERE left NOT BETWEEN right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the where_between method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::where_between
     */
    public function testWhereBetweenReturnsSelfReference()
    {
        $return = $this->builder->where_between('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexp()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_regexp('left', 'right');

        $this->assertEquals('WHERE left REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::where_regexp
     */
    public function testWhereNotRegexp()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_regexp('left', 'right', TRUE);

        $this->assertEquals('WHERE left NOT REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the where_regexp method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexpReturnsSelfReference()
    {
        $return = $this->builder->where_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having
     */
    public function testHavingWithDefaultOperator()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having('left', 'right');

        $this->assertEquals('HAVING left = right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having
     */
    public function testHavingWithCustomOperator()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having('left', 'right', '>');

        $this->assertEquals('HAVING left > right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the having method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::having
     */
    public function testHavingReturnsSelfReference()
    {
        $return = $this->builder->having('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_like
     */
    public function testHavingLike()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_like('left', 'right');

        $this->assertEquals('HAVING left LIKE right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_like
     */
    public function testHavingNotLike()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_like('left', 'right', TRUE);

        $this->assertEquals('HAVING left NOT LIKE right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the having_like method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::having_like
     */
    public function testHavingLikeReturnsSelfReference()
    {
        $return = $this->builder->having_like('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_in
     */
    public function testHavingIn()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_in('left', 'right');

        $this->assertEquals('HAVING left IN right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_in
     */
    public function testHavingNotIn()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_in('left', 'right', TRUE);

        $this->assertEquals('HAVING left NOT IN right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the having_in method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::having_in
     */
    public function testHavingInReturnsSelfReference()
    {
        $return = $this->builder->having_in('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_between
     */
    public function testHavingBetween()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_between('left', 'right');

        $this->assertEquals('HAVING left BETWEEN right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_between
     */
    public function testHavingNotBetween()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_between('left', 'right', TRUE);

        $this->assertEquals('HAVING left NOT BETWEEN right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the having_between method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::having_between
     */
    public function testHavingBetweenReturnsSelfReference()
    {
        $return = $this->builder->having_between('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexp()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_regexp('left', 'right');

        $this->assertEquals('HAVING left REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\DataAccess\MysqlDMLQueryBuilder::having_regexp
     */
    public function testHavingNotRegexp()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_regexp('left', 'right', TRUE);

        $this->assertEquals('HAVING left NOT REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the having_regexp method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexpReturnsSelfReference()
    {
        $return = $this->builder->having_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying a logical AND connector.
     *
     * @covers Lunr\DataAccess\MysqlDMLQueryBuilder::sql_and
     */
    public function testSQLAnd()
    {
        $property = $this->builder_reflection->getProperty('connector');
        $property->setAccessible(TRUE);

        $this->builder->sql_and();

        $this->assertEquals('AND', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the sql_and method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::sql_and
     */
    public function testSQLAndReturnsSelfReference()
    {
        $return = $this->builder->sql_and();

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying a logical OR connector.
     *
     * @covers Lunr\DataAccess\MysqlDMLQueryBuilder::sql_or
     */
    public function testSQLOr()
    {
        $property = $this->builder_reflection->getProperty('connector');
        $property->setAccessible(TRUE);

        $this->builder->sql_or();

        $this->assertEquals('OR', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the sql_or method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::sql_or
     */
    public function testSQLOrReturnsSelfReference()
    {
        $return = $this->builder->sql_or();

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying a logical XOR connector.
     *
     * @covers Lunr\DataAccess\MysqlDMLQueryBuilder::sql_xor
     */
    public function testSQLXor()
    {
        $property = $this->builder_reflection->getProperty('connector');
        $property->setAccessible(TRUE);

        $this->builder->sql_xor();

        $this->assertEquals('XOR', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the sql_xor method.
     *
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::sql_xor
     */
    public function testSQLXorReturnsSelfReference()
    {
        $return = $this->builder->sql_xor();

        $this->assertInstanceOf('Lunr\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}

?>
