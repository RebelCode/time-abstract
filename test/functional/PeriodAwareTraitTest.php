<?php

namespace RebelCode\Time\FuncTest;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use stdClass;
use Xpmock\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since 0.1
 */
class PeriodAwareTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since 0.1
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\PeriodAwareTrait';

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
        $mock = $this->getMockForTrait(
            static::TEST_SUBJECT_CLASSNAME
        );

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
     * Tests the period getter and setter methods with a valid period instance.
     *
     * @since 0.1
     */
    public function testGetSetPeriod()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $period = $this->mock('Dhii\Time\PeriodInterface')
            ->getStart()
            ->getEnd()
            ->getDuration()
            ->new();

        $reflect->_setPeriod($period);

        $this->assertSame($period, $reflect->_getPeriod(), 'Set and retrieved period are not the same');
    }

    /**
     * Tests the period getter and setter methods with a null value.
     *
     * @since 0.1
     */
    public function testGetSetPeriodNull()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setPeriod(null);

        $this->assertNull($reflect->_getPeriod(), 'Retrieved period is not null');
    }

    /**
     * Tests the period getter and setter methods with an invalid instance.
     *
     * @since 0.1
     */
    public function testGetSetPeriodInvalid()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $object = new stdClass();

        $this->setExpectedException('InvalidArgumentException');

        $reflect->_setPeriod($object);
    }
}
