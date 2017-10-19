<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;
use InvalidArgumentException;

/**
 * Common functionality for objects that are aware of a start timestamp.
 *
 * @since [*next-version*]
 */
trait StartAwareTrait
{
    /**
     * The start timestamp: the number of seconds since unix epoch.
     *
     * @since [*next-version*]
     *
     * @var int
     */
    protected $start;

    /**
     * Retrieves the start timestamp.
     *
     * @since [*next-version*]
     *
     * @return int The start timestamp, as the number of seconds since unix epoch.
     */
    protected function _getStart()
    {
        return $this->start;
    }

    /**
     * Sets the start timestamp.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable $start The start timestamp, as the number of seconds since unix epoch.
     *                                     Negative numbers are allowed.
     */
    protected function _setStart($start)
    {
        $this->start = $this->_sanitizeTimestamp($start);
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
