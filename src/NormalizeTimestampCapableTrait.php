<?php

namespace RebelCode\Time;

use Dhii\Time\TimeInterface;
use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

/**
 * Common functionality for objects that can normalize timestamps.
 *
 * @since [*next-version*]
 */
trait NormalizeTimestampCapableTrait
{
    /**
     * Normalizes a timestamp to an integer number.
     *
     * @since [*next-version*]
     *
     * @param int|float|string|Stringable|TimeInterface $timestamp The timestamp.
     *
     * @throws InvalidArgumentException If value cannot be normalized.
     *
     * @return int The normalized timestamp.
     */
    protected function _normalizeTimestamp($timestamp)
    {
        if ($timestamp instanceof TimeInterface) {
            $timestamp = $timestamp->getTimestamp();
        }

        return $this->_normalizeInt($timestamp);
    }

    /**
     * Normalizes a value into an integer.
     *
     * The value must be a whole number, or a string representing such a number,
     * or an object representing such a string.
     *
     * @since [*next-version*]
     *
     * @param int|float|string|Stringable $value The value to normalize.
     *
     * @throws InvalidArgumentException If value cannot be normalized.
     *
     * @return int The normalized value.
     */
    abstract protected function _normalizeInt($value);
}
