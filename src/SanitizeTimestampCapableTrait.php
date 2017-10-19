<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface;
use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;
use InvalidArgumentException;

/**
 * Common functionality for objects that can sanitize timestamps.
 *
 * @since [*next-version*]
 */
trait SanitizeTimestampCapableTrait
{
    /**
     * Sanitizes a timestamp to an integer number.
     *
     * @since [*next-version*]
     *
     * @param int|string|StringableInterface|null $timestamp The timestamp.
     *
     * @return int The sanitized timestamp.
     */
    protected function _sanitizeTimestamp($timestamp)
    {
        $isObject     = is_object($timestamp);
        $isArray      = is_array($timestamp);
        $isStringable = $isObject && method_exists($timestamp, '__toString');

        // Get the string representation - this should lead to no loss of information
        $stringVal = (!$isObject && !$isArray) || $isStringable
            ? strval($timestamp)
            : null;

        // Get the integer value - some data in the string might be lost here
        $intVal = intval($stringVal);

        // Cast back into a string and check if equivalence was lost due to data loss
        $isInt = $stringVal === strval($intVal);

        if (!$isInt) {
            throw $this->_createInvalidArgumentException(
                $this->__('Argument is not a valid timestamp'),
                null,
                null,
                $timestamp
            );
        }

        return $intVal;
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
     *
     * @param string $string  The format string to translate.
     * @param array  $args    Placeholder values to replace in the string.
     * @param mixed  $context The context for translation.
     *
     * @return string The translated string.
     */
    abstract protected function __($string, $args = [], $context = null);
}
