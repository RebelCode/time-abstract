<?php

namespace RebelCode\Time\UnitTest;

use PHPUnit_Framework_MockObject_MockObject;
use RebelCode\Time\IntervalInterface;
use RebelCode\Time\PeriodInterface;
use RebelCode\Time\TimeInterface;
use Xpmock\TestCase;
use RebelCode\Time\AbstractIteratorRecurringTime as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractIteratorRecurringTimeTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\AbstractIteratorRecurringTime';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods The methods to mock.
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function createInstance(array $methods = [])
    {
        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME);

        $allMethods = array_merge(
            [
                '_getPeriod',
                '_getInterval',
                '_createTime',
            ],
            $methods
        );

        $mock->setMethods($allMethods);

        return $mock->getMockForAbstractClass();
    }

    /**
     * Creates a new time period object for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param TimeInterface $start The start time.
     * @param TimeInterface $end   The end time.
     *
     * @return PeriodInterface The mocked time period instance.
     */
    public function createPeriod(TimeInterface $start, TimeInterface $end)
    {
        return $this->mock('RebelCode\Time\PeriodInterface')
                    ->getStart($start)
                    ->getEnd($end)
                    ->getDuration($end->getTimestamp() - $start->getTimestamp())
                    ->new();
    }

    /**
     * Creates a new time object for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param int $timestamp The timestamp.
     *
     * @return TimeInterface The mocked time instance.
     */
    public function createTime($timestamp)
    {
        return $this->mock('RebelCode\Time\TimeInterface')
                    ->getTimestamp($timestamp)
                    ->new();
    }

    /**
     * Creates a new interval object for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param int $duration The duration in seconds.
     *
     * @return IntervalInterface The mocked interval instance.
     */
    public function createInterval($duration)
    {
        return $this->mock('RebelCode\Time\IntervalInterface')
                    ->getDuration($duration)
                    ->new();
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME,
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests the reset method to ensure that all the data associated with iteration is reset.
     *
     * @since [*next-version*]
     */
    public function testReset()
    {
        $period = $this->createPeriod(
            $start = $this->createTime(rand(0, 100)),
            $end = $this->createTime(rand(100, 200))
        );

        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        // Mock subject's period awareness
        $subject->method('_getPeriod')->willReturn($period);

        // Expect the create time function to be called with the period's start
        // This determines whether the first yielded value is at the start of the period
        // Hence concluding that the reset worked.
        $subject->expects($this->once())
                ->method('_createTime')
                ->with($period->getStart()->getTimestamp());

        $reflect->_reset();
        $reflect->_current();
    }

    /**
     * Tests the next, current and key methods to ensure that advancement of time works correctly.
     *
     * @since [*next-version*]
     */
    public function testNextCurrent()
    {
        $period = $this->createPeriod(
            $start = $this->createTime(rand(0, 3600)),
            $end = $this->createTime(rand(7200, 18000))
        );
        $interval = $this->createInterval(rand(60, 1800));

        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        // Mock subject's period and interval awareness
        $subject->method('_getPeriod')->willReturn($period);
        $subject->method('_getInterval')->willReturn($interval);
        $subject->method('_createTime')->willReturnCallback(
            function ($t) {
                return $this->createTime($t);
            }
        );

        $reflect->_reset();

        $reflect->_next();
        $c1 = $reflect->_current();
        $e1 = $start->getTimestamp() + $interval->getDuration();
        $this->assertEquals($e1, $c1->getTimestamp(), 'Expected time and yielded time are not the same.');
        $this->assertEquals($e1, $reflect->_key(), 'Expected key and yielded key are not the same.');

        $reflect->_next();
        $c2 = $reflect->_current();
        $e2 = $c1->getTimestamp() + $interval->getDuration();
        $this->assertEquals($e2, $c2->getTimestamp(), 'Expected time and yielded time are not the same.');
        $this->assertEquals($e2, $reflect->_key(), 'Expected key and yielded key are not the same.');
    }

    /**
     * Tests the valid method to ensure that it correctly determines when the end has been reached.
     *
     * @since [*next-version*]
     */
    public function testValid()
    {
        $period = $this->createPeriod(
            $start = $this->createTime(rand(0, 200)),
            $end = $this->createTime(rand(400, 600))
        );
        // Interval min rand value must be greater than (start.max - end.min), so that the first
        // advancement causes invalidity
        $interval = $this->createInterval(rand(800, 1000));

        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        // Mock subject's period and interval awareness
        $subject->method('_getPeriod')->willReturn($period);
        $subject->method('_getInterval')->willReturn($interval);

        $reflect->_reset();
        $this->assertTrue($reflect->_valid(), 'Subject is expected to be initially valid.');

        $reflect->_next();
        $this->assertFalse($reflect->_valid(), 'Subject is expected to be invalid upon first advancement.');
    }
}
