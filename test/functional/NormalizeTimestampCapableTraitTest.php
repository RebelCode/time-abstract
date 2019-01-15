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
class NormalizeTimestampCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since 0.1
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\NormalizeTimestampCapableTrait';

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
                     ->setMethods(['_normalizeInt'])
                     ->getMockForTrait();

        return $mock;
    }

    /**
     * Creates a new mock time instance.
     *
     * @since 0.1
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function createTime()
    {
        // Create mock
        $mock = $this->getMockBuilder('Dhii\Time\TimeInterface')
                     ->setMethods(['getTimestamp'])
                     ->getMockForAbstractClass();

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
     * Tests the normalize timestamp method when the argument is a scalar and normalization is successful.
     *
     * @since 0.1
     */
    public function testSanitizeTimestampScalar()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);
        $input    = rand();
        $newInput = rand();

        $subject->expects($this->once())
                ->method('_normalizeInt')
                ->with($input)
                ->willReturn($newInput);

        $this->assertEquals($newInput, $output = $reflect->_normalizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the normalize timestamp method when the argument is a time object and normalization is successful.
     *
     * @since 0.1
     */
    public function testSanitizeTimestamp()
    {
        $subject    = $this->createInstance();
        $reflect    = $this->reflect($subject);
        $input      = $this->createTime();
        $timestamp  = rand(0, time());
        $normalized = rand(0, time());

        $input->expects($this->once())
              ->method('getTimestamp')
              ->willReturn($timestamp);

        $subject->expects($this->once())
                ->method('_normalizeInt')
                ->with($timestamp)
                ->willReturn($normalized);

        $this->assertEquals($normalized, $output = $reflect->_normalizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the normalize timestamp method when integer normalize fails.
     *
     * @since 0.1
     */
    public function testSanitizeTimestampFail()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input   = rand();

        $this->setExpectedException('InvalidArgumentException');

        $subject->method('_normalizeInt')
                ->willThrowException(new InvalidArgumentException());

        $reflect->_normalizeTimestamp($input);
    }
}
