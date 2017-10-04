<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use stdClass;
use Xpmock\TestCase;
use RebelCode\Time\RecurringTimeAwareTrait as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class RecurringTimeAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\RecurringTimeAwareTrait';

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
     * Tests the recurring time getter and setter methods with a valid instance.
     *
     * @since [*next-version*]
     */
    public function testGetSetRecurringTime()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $rTime   = $this->mock('RebelCode\Time\RecurringTimeInterface')
                        ->getPeriod()
                        ->getInterval()
                        ->new();

        $reflect->_setRecurringTime($rTime);

        $this->assertSame(
            $rTime,
            $reflect->_getRecurringTime(),
            'Set and retrieved recurring time objects are not the same'
        );
    }

    /**
     * Tests the recurring time getter and setter methods with a null value.
     *
     * @since [*next-version*]
     */
    public function testGetSetRecurringTimeNull()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setRecurringTime(null);

        $this->assertNull($reflect->_getRecurringTime(), 'Retrieved recurring time object is not null');
    }

    /**
     * Tests the recurring time getter and setter methods with an invalid instance.
     *
     * @since [*next-version*]
     */
    public function testGetSetRecurringTimeInvalid()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $object  = new stdClass();

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setRecurringTime($object);
    }
}
