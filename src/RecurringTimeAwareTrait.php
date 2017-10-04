<?php

namespace RebelCode\Time;

use InvalidArgumentException;
use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;

/**
 * Common functionality for objects that are aware of a recurring time object.
 *
 * @since [*next-version*]
 */
trait RecurringTimeAwareTrait
{
    /**
     * The recurring time object.
     *
     * @since [*next-version*]
     *
     * @var RecurringTimeInterface
     */
    protected $recurringTime;

    /**
     * Retrieves the recurring time object associated to this instance.
     *
     * @since [*next-version*]
     *
     * @return RecurringTimeInterface The recurring time object.
     */
    protected function _getRecurringTime()
    {
        return $this->recurringTime;
    }

    /**
     * Sets the recurring time object for this instance.
     *
     * @since [*next-version*]
     *
     * @param RecurringTimeInterface $recurringTime The recurring time object.
     */
    protected function _setRecurringTime($recurringTime)
    {
        if ($recurringTime !== null && !($recurringTime instanceof RecurringTimeInterface)) {
            throw $this->_createInvalidArgumentException(
                $this->__('Argument is not a valid recurring time instance'),
                null,
                null,
                $recurringTime
            );
        }

        $this->recurringTime = $recurringTime;
    }

    /**
     * Creates a new invalid argument exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|null $message  The error message, if any.
     * @param int|null               $code     The error code, if any.
     * @param RootException|null     $previous The inner exception for chaining, if any.
     * @param mixed|null             $argument The invalid argument, if any.
     *
     * @return InvalidArgumentException The new exception.
     */
    abstract protected function _createInvalidArgumentException(
        $message = null,
        $code = null,
        RootException $previous = null,
        $argument = null
    );

    /**
     * Translates a string, and replaces placeholders.
     *
     * @since [*next-version*]
     * @see   sprintf()
     *
     * @param string $string  The format string to translate.
     * @param array  $args    Placeholder values to replace in the string.
     * @param mixed  $context The context for translation.
     *
     * @return string The translated string.
     */
    abstract protected function __($string, $args = [], $context = null);
}
