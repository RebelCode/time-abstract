<?php

namespace RebelCode\Time\FuncTest;

use DateTimeZone;
use Exception;
use OutOfRangeException;
use RebelCode\Time\CreateDateTimeZoneCapableTrait as TestSubject;
use Xpmock\TestCase;
use Exception as RootException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CreateDateTimeZoneCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\Time\CreateDateTimeZoneCapableTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods The methods to mock.
     *
     * @return TestSubject|MockObject The new instance.
     */
    public function createInstance($methods = [])
    {
        $methods = $this->mergeValues($methods, [
            '_createInvalidArgumentException',
            '_createOutOfRangeException',
            '_normalizeString',
            '__',
        ]);

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
                     ->setMethods($methods)
                     ->getMockForTrait();

        $mock->method('__')->will($this->returnArgument(0));

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @since [*next-version*]
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a mock that both extends a class and implements interfaces.
     *
     * This is particularly useful for cases where the mock is based on an
     * internal class, such as in the case with exceptions. Helps to avoid
     * writing hard-coded stubs.
     *
     * @since [*next-version*]
     *
     * @param string   $className      Name of the class for the mock to extend.
     * @param string[] $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return MockObject The object that extends and implements the specified class and interfaces.
     */
    public function mockClassAndInterfaces($className, $interfaceNames = [])
    {
        $paddingClassName = uniqid($className);
        $definition = vsprintf('abstract class %1$s extends %2$s implements %3$s {}', [
            $paddingClassName,
            $className,
            implode(', ', $interfaceNames),
        ]);
        eval($definition);

        return $this->getMockForAbstractClass($paddingClassName);
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException|MockObject The new exception.
     */
    public function createException($message = '')
    {
        $mock = $this->getMockBuilder('Exception')
                     ->setConstructorArgs([$message])
                     ->getMock();

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
            'A valid instance of the test subject could not be created.'
        );
    }

    public function testCreateDateTimeZone()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $paramTzName = 'Europe/Malta';
        $normTzName = 'Europe/Kiev';

        $subject->expects($this->once())
                ->method('_normalizeString')
                ->with($paramTzName)
                ->willReturn($normTzName);

        try {
            /* @var $result DateTimeZone */
            $result = $reflect->_createDateTimeZone($paramTzName);

            $this->assertInstanceOf('DateTimeZone', $result);
            $this->assertEquals($normTzName, $result->getName());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testCreateDateTimeZoneUtcOffset()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $paramTzName = 'UTC+5';

        $subject->expects($this->once())
                ->method('_normalizeString')
                ->with($paramTzName)
                ->willReturnArgument(0);
        $subject->method('_createOutOfRangeException')->willReturn(new OutOfRangeException());

        $supportsOffsets = version_compare(phpversion(), '5.5.10', '>=');

        try {
            $result = $reflect->_createDateTimeZone($paramTzName);

            if ($supportsOffsets) {
                $this->assertInstanceOf('DateTimeZone', $result);
                $this->assertEquals('+05:00', $result->getName());
            } else {
                $this->fail('Expected subject to fail with offset timezone string (since version is pre-5.5)');
            }
        } catch (Exception $exception) {
            if ($supportsOffsets) {
                $this->fail($exception->getMessage());
            } else {
                $this->assertInstanceOf('OutOfRangeException', $exception);
            }
        }
    }

    public function testCreateDateTimeZoneUtcOffsetNegative()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $paramTzName = 'UTC-12';

        $subject->expects($this->once())
                ->method('_normalizeString')
                ->with($paramTzName)
                ->willReturnArgument(0);
        $subject->method('_createOutOfRangeException')->willReturn(new OutOfRangeException());

        $supportsOffsets = version_compare(phpversion(), '5.5.10', '>=');

        try {
            $result = $reflect->_createDateTimeZone($paramTzName);

            if ($supportsOffsets) {
                $this->assertInstanceOf('DateTimeZone', $result);
                $this->assertEquals('-12:00', $result->getName());
            } else {
                $this->fail('Expected subject to fail with offset timezone string (since version is pre-5.5)');
            }
        } catch (Exception $exception) {
            if ($supportsOffsets) {
                $this->fail($exception->getMessage());
            } else {
                $this->assertInstanceOf('OutOfRangeException', $exception);
            }
        }
    }
}
