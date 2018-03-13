<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use Xpmock\TestCase;
use RebelCode\Time\EndAwareTrait as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class EndAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\EndAwareTrait';

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
        $mock->method('_createArgumentException')->willReturnCallback(
            function ($msg = '', $code = 0, $prev = null) {
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
    public function testGetSetEnd()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input = rand();
        $output = rand();

        $subject->expects($this->once())
                ->method('_normalizeTimestamp')
                ->with($input)
                ->willReturn($output);

        $reflect->_setEnd($input);

        $this->assertEquals($output, $reflect->_getEnd(), 'Retrieved value is not equal to normalized input.');
    }

    /**
     * Tests the getter and setter methods with normalization failure to assert whether an exception is thrown.
     *
     * @since [*next-version*]
     */
    public function testGetSetEndNormalizationFail()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $first = rand();
        $second = rand();

        $reflect->_setEnd($first);

        $subject->expects($this->once())
                ->method('_normalizeTimestamp')
                ->with($second)
                ->willThrowException(new InvalidArgumentException());

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setEnd($second);

        $this->assertEquals($first, $reflect->_getEnd(), 'Timestamp is not equal to previous value.');
    }
}
