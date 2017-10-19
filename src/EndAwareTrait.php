<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;
use InvalidArgumentException;

/**
 * Common functionality for objects that are aware of an end timestamp.
 *
 * @since [*next-version*]
 */
trait EndAwareTrait
{
    /**
     * The end timestamp: the number of seconds since unix epoch.
     *
     * @since [*next-version*]
     *
     * @var int
     */
    protected $end;

    /**
     * Retrieves the end timestamp.
     *
     * @since [*next-version*]
     *
     * @return int The end timestamp, as the number of seconds since unix epoch.
     */
    protected function _getEnd()
    {
        return $this->end;
    }

    /**
     * Sets the end timestamp.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable $end The end timestamp, as the number of seconds since unix epoch.
     *                                   Negative numbers are allowed.
     */
    protected function _setEnd($end)
    {
        $this->end = $this->_sanitizeTimestamp($end);
    }

    /**
     * Sanitizes a timestamp to an integer number.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable|null $timestamp The timestamp.
     *
     * @return int The sanitized timestamp.
     */
    abstract protected function _sanitizeTimestamp($timestamp);

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
     *
     * @param string $string  The format string to translate.
     * @param array  $args    Placeholder values to replace in the string.
     * @param mixed  $context The context for translation.
     *
     * @return string The translated string.
     */
    abstract protected function __($string, $args = [], $context = null);
}
