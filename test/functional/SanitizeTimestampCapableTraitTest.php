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
class SanitizeTimestampCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\SanitizeTimestampCapableTrait';

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
                     ->setMethods(['__', '_createInvalidArgumentException'])
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
     * Tests the sanitize method with an integer.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampInt()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input   = rand();

        $this->assertEquals($input, $output = $reflect->_sanitizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the sanitize method with a negative integer.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampIntNegative()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input   = - rand();

        $this->assertEquals($input, $output = $reflect->_sanitizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the sanitize method with a float.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampFloat()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $float = (float)rand() / (float)getrandmax();

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_sanitizeTimestamp($float);
    }

    /**
     * Tests the sanitize method with a float that is a whole number.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampFloatInt()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $integer = rand();
        $input   = floatval($integer);

        $this->assertEquals($integer, $output = $reflect->_sanitizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the sanitize method with a negative float.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampFloatNegative()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $integer = -rand();
        $input   = floatval($integer);

        $this->assertEquals($integer, $output = $reflect->_sanitizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the sanitize method with a valid numeric string.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampString()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $integer = rand();
        $input   = "$integer";

        $this->assertEquals($integer, $output = $reflect->_sanitizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the sanitize method with a valid negative numeric string.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampStringNegative()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $integer = - rand();
        $input   = "$integer";

        $this->assertEquals($integer, $output = $reflect->_sanitizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the sanitize method with an invalid string.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampStringInvalid()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input   = uniqid('not-numeric-');

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_sanitizeTimestamp($input);
    }

    /**
     * Tests the sanitize method with a valid stringable instance.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampStringable()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $integer = rand();
        $string  = "$integer";
        $input   = $this->mock('Dhii\Util\String\StringableInterface')
                        ->__toString($string)
                        ->new();

        $this->assertEquals($integer, $output = $reflect->_sanitizeTimestamp($input));
        $this->assertInternalType('integer', $output);
    }

    /**
     * Tests the sanitize method with an invalid input.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampInvalid()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input   = new stdClass();

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_sanitizeTimestamp($input);
    }

    /**
     * Tests the sanitize method with an invalid input.
     *
     * @since [*next-version*]
     */
    public function testSanitizeTimestampNull()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $input   = null;

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_sanitizeTimestamp($input);
    }
}
