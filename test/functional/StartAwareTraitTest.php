<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since 0.1
 */
class StartAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since 0.1
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\StartAwareTrait';

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
        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
                     ->setMethods(['__', '_createInvalidArgumentException', '_normalizeTimestamp'])
                     ->getMockForTrait();

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
     * Tests the getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since 0.1
     */
    public function testGetSetStart()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input = rand();
        $output = rand();

        $subject->expects($this->once())
                ->method('_normalizeTimestamp')
                ->with($input)
                ->willReturn($output);

        $reflect->_setStart($input);

        $this->assertEquals($output, $reflect->_getStart(), 'Retrieved value is not equal to normalized input.');
    }

    /**
     * Tests the getter and setter methods when normalization fails to ensure that exceptions are thrown and that
     * invalid timestamps are not set.
     *
     * @since 0.1
     */
    public function testGetSetStartNormalizationFail()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $first = rand();
        $second = rand();

        $reflect->_setStart($first);

        $subject->expects($this->once())
                ->method('_normalizeTimestamp')
                ->with($second)
                ->willThrowException(new InvalidArgumentException());

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setStart($second);

        $this->assertEquals($first, $reflect->_getStart());
    }
}
