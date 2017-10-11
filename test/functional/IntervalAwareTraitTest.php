<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use RebelCode\Time\IntervalAwareTrait as TestSubject;
use stdClass;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class IntervalAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\IntervalAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return TestSubject
     */
    public function createInstance()
    {
        // Create mock
        $mock = $this->getMockForTrait(static::TEST_SUBJECT_CLASSNAME);

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
     * Tests the interval getter and setter methods with a valid interval instance.
     *
     * @since [*next-version*]
     */
    public function testGetSetInterval()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $interval = $this->mock('Dhii\Time\IntervalInterface')
                        ->getDuration()
                        ->new();

        $reflect->_setInterval($interval);

        $this->assertSame($interval, $reflect->_getInterval(), 'Set and retrieved interval are not the same');
    }

    /**
     * Tests the interval getter and setter methods with a null value.
     *
     * @since [*next-version*]
     */
    public function testGetSetIntervalNull()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setInterval(null);

        $this->assertNull($reflect->_getInterval(), 'Retrieved interval is not null');
    }

    /**
     * Tests the interval getter and setter methods with an invalid instance.
     *
     * @since [*next-version*]
     */
    public function testGetSetIntervalInvalid()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $object = new stdClass();

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setInterval($object);
    }
}
