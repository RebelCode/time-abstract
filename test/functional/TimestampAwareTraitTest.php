<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use RebelCode\Time\TimestampAwareTrait as TestSubject;
use stdClass;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class TimestampAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\TimestampAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function createInstance()
    {
        // Create mock
        $mock = $this->getMockForTrait(
            static::TEST_SUBJECT_CLASSNAME
        );

        $mock->method('_createInvalidArgumentException')->willReturnCallback(
            function ($message) {
                return new InvalidArgumentException($message);
            }
        );
        $mock->method('__')->willReturnArgument(0);

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInternalType(
            'object',
            $subject,
            'An instance of the test subject could not be created'
        );
    }

    /**
     * Tests the timestamp getter and setter methods with an integer.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampInt()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = rand(0, PHP_INT_MAX);

        $reflect->_setTimestamp($timestamp);

        $this->assertEquals($timestamp, $reflect->_getTimestamp(), 'Set and retrieved timestamps do not match');
        $this->assertInternalType('int', $reflect->_getTimestamp());
    }

    /**
     * Tests the timestamp getter and setter methods with an integer string.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampIntString()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = (string) rand(0, PHP_INT_MAX);

        $reflect->_setTimestamp($timestamp);

        $this->assertEquals($timestamp, $reflect->_getTimestamp(), 'Set and retrieved timestamps do not match');
        $this->assertInternalType('int', $reflect->_getTimestamp());
    }

    /**
     * Tests the timestamp getter and setter methods with a stringable instance that casts into an integer string.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampIntStringable()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = rand(0, PHP_INT_MAX);
        $stringable = $this->mock('Dhii\Util\String\StringableInterface')
            ->__toString((string) $timestamp)
            ->new();

        $reflect->_setTimestamp($stringable);

        $this->assertEquals($timestamp, $reflect->_getTimestamp(), 'Set and retrieved timestamps do not match');
        $this->assertInternalType('int', $reflect->_getTimestamp());
    }

    /**
     * Tests the timestamp getter and setter methods with a negative integer.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampNegative()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = rand(0, -PHP_INT_MAX);

        $reflect->_setTimestamp($timestamp);

        $this->assertEquals($timestamp, $reflect->_getTimestamp(), 'Set and retrieved timestamps do not match');
        $this->assertInternalType('int', $reflect->_getTimestamp());
    }

    /**
     * Tests the timestamp getter and setter methods with a negative integer string.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampNegativeString()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = (string) rand(0, -PHP_INT_MAX);

        $reflect->_setTimestamp($timestamp);

        $this->assertEquals($timestamp, $reflect->_getTimestamp(), 'Set and retrieved timestamps do not match');
        $this->assertInternalType('int', $reflect->_getTimestamp());
    }

    /**
     * Tests the timestamp getter and setter methods with a float.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampFloat()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = rand(0, PHP_INT_MAX) + 0.1;

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setTimestamp($timestamp);
    }

    /**
     * Tests the timestamp getter and setter methods with any other object.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampObject()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = new stdClass();

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setTimestamp($timestamp);
    }
}
