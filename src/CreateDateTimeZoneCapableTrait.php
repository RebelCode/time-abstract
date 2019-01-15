<?php

namespace RebelCode\Time;

use DateTimeZone;
use Dhii\Util\String\StringableInterface as Stringable;
use Exception;
use InvalidArgumentException;
use OutOfRangeException;

/**
 * Functionality for creating time zone object instances.
 *
 * If using PHP 5.5.10 or later, UTC offset names in any of the following forms are also accepted:
 * - simple offset with optional "UTC" part: "UTC+2", "UTC-7", "+5", "-3"
 * - colon notation with optional "UTC" part: "UTC+2:30", "UTC-7:15", "+5:55", "-3:20"
 * - dot notation with optional "UTC" part: "UTC+2.5", "UTC-7.5", "+5.25", "-3.75"
 *
 * @since 0.1
 */
trait CreateDateTimeZoneCapableTrait
{
    /**
     * Creates a {@link DateTimeZone} object for a timezone, by name.
     *
     * @see   DateTimeZone
     * @since 0.1
     *
     * @param string|Stringable $tzName The name of the timezone.
     *
     * @throws InvalidArgumentException If the timezone name is not a string or stringable object.
     * @throws OutOfRangeException      If the timezone name is invalid and does not represent a valid timezone.
     *
     * @return DateTimeZone The created {@link DateTimeZone} instance.
     */
    protected function _createDateTimeZone($tzName)
    {
        $argTz = $tzName;
        $tzName = $this->_normalizeString($tzName);

        // Handle UTC offset timezone in colon notation
        if (preg_match('/^(?:UTC)?(\+|\-)(\d{1,2})(:?(\d{2}))?$/', $tzName, $matches) && count($matches) >= 2) {
            $sign = $matches[1];
            $hours = (int) $matches[2];
            $minutes = count($matches) >= 4 ? (int) $matches[4] : 0;
            $tzName = sprintf('%s%02d%02d', $sign, $hours, $minutes);
        }
        // Handle UTC offset timezone in dot notation
        else if (preg_match('/^(?:UTC)?(\+|\-)(\d{1,2})(\.?(\d{1,2}))?$/', $tzName, $matches) && count($matches) >= 2) {
            $sign = $matches[1];
            $hours = (int) $matches[2];
            $dotPart = count($matches) >= 4 ? $matches[4] : "0";
            $dotPart2 = strlen($dotPart) < 2 ? $dotPart . "0" : $dotPart;
            $minutes = intval($dotPart2) * 0.6;
            $tzName = sprintf('%s%02d%02d', $sign, $hours, $minutes);
        }

        try {
            return new DateTimeZone($tzName);
        } catch (Exception $exception) {
            throw $this->_createOutOfRangeException(
                $this->__('Invalid timezone name: "%1$s"', [$argTz]), null, $exception, $argTz
            );
        }
    }

    /**
     * Normalizes a value to its string representation.
     *
     * The values that can be normalized are any scalar values, as well as
     * {@see StringableInterface).
     *
     * @since 0.1
     *
     * @param Stringable|string|int|float|bool $subject The value to normalize to string.
     *
     * @throws InvalidArgumentException If the value cannot be normalized.
     *
     * @return string The string that resulted from normalization.
     */
    abstract protected function _normalizeString($subject);

    /**
     * Creates a new invalid argument exception.
     *
     * @since 0.1
     *
     * @param string|Stringable|null $message  The error message, if any.
     * @param int|null               $code     The error code, if any.
     * @param Exception|null         $previous The inner exception for chaining, if any.
     * @param mixed|null             $argument The invalid argument, if any.
     *
     * @return InvalidArgumentException The new exception.
     */
    abstract protected function _createInvalidArgumentException(
        $message = null,
        $code = null,
        Exception $previous = null,
        $argument = null
    );

    /**
     * Creates a new Dhii Out Of Range exception.
     *
     * @since 0.1
     *
     * @param string|Stringable|int|float|bool|null $message  The message, if any.
     * @param int|float|string|Stringable|null      $code     The numeric error code, if any.
     * @param Exception|null                        $previous The inner exception, if any.
     * @param mixed|null                            $argument The value that is out of range, if any.
     *
     * @return OutOfRangeException The new exception.
     */
    abstract protected function _createOutOfRangeException(
        $message = null,
        $code = null,
        Exception $previous = null,
        $argument = null
    );

    /**
     * Translates a string, and replaces placeholders.
     *
     * @since 0.1
     *
     * @param string $string  The format string to translate.
     * @param array  $args    Placeholder values to replace in the string.
     * @param mixed  $context The context for translation.
     *
     * @return string The translated string.
     */
    abstract protected function __($string, $args = [], $context = null);
}
