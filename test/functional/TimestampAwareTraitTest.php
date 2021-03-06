<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\Time\TimestampAwareTrait}.
 *
 * @since 0.1
 */
class TimestampAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since 0.1
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\TimestampAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since 0.1
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
     * @since 0.1
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
     * @since 0.1
     */
    public function testGetSetTimestamp()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $timestamp = rand();

        $subject->expects($this->once())
                ->method('_normalizeTimestamp')
                ->with($timestamp)
                ->willReturnArgument(0);

        $reflect->_setTimestamp($timestamp);

        $this->assertEquals(
            $timestamp,
            $reflect->_getTimestamp(),
            'Retrieved value is not equal to normalized input.'
        );
    }

    /**
     * Tests the getter and setter methods to ensure that the timestamp is not set when normalization fails.
     *
     * @since 0.1
     */
    public function testGetSetTimestampNormalizationFail()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $first = rand();
        $second = rand();

        $reflect->_setTimestamp($first);

        $subject->method('_normalizeTimestamp')->willThrowException(new InvalidArgumentException());

        $this->setExpectedException('InvalidArgumentException');
        $reflect->_setTimestamp($second);

        $this->assertEquals($first, $reflect->_getTimestmap(), 'Timestamp is not equal to previously set value.');
    }
}
