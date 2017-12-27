<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use stdClass;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class NormalizeTimestampCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\NormalizeTimestampCapableTrait';

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
                     ->setMethods(['_normalizeInt'])
                     ->getMockForTrait();

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
     * Tests the normalize timestamp method when the integer normalization is successful.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestamp()
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
     * Tests the normalize timestamp method when integer normalize fails
     *
     * @since [*next-version*]
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
