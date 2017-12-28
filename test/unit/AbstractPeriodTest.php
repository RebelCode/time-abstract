<?php

namespace RebelCode\Time\UnitTest;

use RebelCode\Time\TimeInterface;
use Xpmock\TestCase;
use RebelCode\Time\AbstractPeriod as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractPeriodTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\AbstractPeriod';

    /**
     * Creates a time instance for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param int $timestamp The timestamp.
     *
     * @return TimeInterface
     */
    public function createTimeInstance($timestamp)
    {
        $mock = $this->mock('Dhii\Time\TimeInterface')
                     ->getTimestamp($timestamp);

        return $mock->new();
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                        ->_getStart()
                        ->_getEnd()
                        ->_getDuration()
                        ->new();

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME,
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests the duration getter method.
     *
     * @since [*next-version*]
     */
    public function testGetDuration()
    {
        $start = rand(0, PHP_INT_MAX);
        $end = rand(0, PHP_INT_MAX);
        $diff = $end - $start;

        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                     ->_getStart([], $this->createTimeInstance($start), $this->once())
                     ->_getEnd([], $this->createTimeInstance($end), $this->once());

        $subject = $mock->new();
        $reflect = $this->reflect($subject);

        $this->assertEquals($diff, $reflect->_getDuration(), 'Calculated duration is incorrect.');
    }
}
