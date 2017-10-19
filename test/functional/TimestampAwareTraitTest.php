<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\Time\TimestampAwareTrait}.
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
            function($message) {
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
        $subject   = $this->createInstance();
        $reflect   = $this->reflect($subject);
        $timestamp = rand(0, PHP_INT_MAX);

        $subject->method('_sanitizeTimestamp')->willReturnArgument(0);
        $reflect->_setTimestamp($timestamp);

        $this->assertEquals(
            $timestamp,
            $output = $reflect->_getTimestamp(),
            'Set and retrieved timestamps do not match'
        );
        $this->assertInternalType('int', $output);
    }

    /**
     * Tests the getter and setter methods to ensure that the timestamp is not set when sanitization fails.
     *
     * @since [*next-version*]
     */
    public function testGetSetTimestampSanitizeFail()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $first   = rand(0, PHP_INT_MAX);
        $second  = rand(0, PHP_INT_MAX);

        $reflect->_setTimestamp($first);

        $subject->method('_sanitizeTimestamp')->willThrowException(new InvalidArgumentException());

        $this->setExpectedException('InvalidArgumentException');
        $reflect->_setTimestamp($second);

        $this->assertEquals($first, $reflect->_getTimestmap(), 'Timestamp is not equal to previously set value.');
    }
}
