<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class DurationAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\DurationAwareTrait';

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
        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
                     ->setMethods(['__', '_createInvalidArgumentException', '_normalizeTimestamp'])
                     ->getMockForTrait();

        $mock->method('__')->willReturnArgument(0);
        $mock->method('_createInvalidArgumentException')->willReturnCallback(
            function($msg = '', $code = 0, $prev = null) {
                return new InvalidArgumentException($msg, $code, $prev);
            }
        );

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
     * Tests the getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetDuration()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input   = rand();
        $output  = rand();

        $subject->expects($this->once())
                ->method('_normalizeTimestamp')
                ->with($input)
                ->willReturn($output);

        $reflect->_setDuration($input);

        $this->assertSame($output, $reflect->_getDuration(), 'Retrieved value is not equal to sanitized input.');
    }

    /**
     * Tests the getter and setter methods with normalization failure to assert whether an exception is thrown.
     *
     * @since [*next-version*]
     */
    public function testGetSetDurationNormalizeFail()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $first   = rand();
        $second  = rand();

        $reflect->_setDuration($first);

        $subject->expects($this->once())
                ->method('_normalizeTimestamp')
                ->with($second)
                ->willThrowException(new InvalidArgumentException());

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setDuration($second);

        $this->assertEquals($first, $reflect->_getDuration(), 'Duration is not equal to previously set value.');
    }
}
