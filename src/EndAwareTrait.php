<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;
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
        $this->end = $this->_normalizeTimestamp($end);
    }

    /**
     * Normalizes a timestamp to an integer number.
     *
     * @since [*next-version*]
     *
     * @param int|float|string|Stringable $timestamp The timestamp.
     *
     * @throws InvalidArgumentException If value cannot be normalized.
     *
     * @return int The normalized timestamp.
     */
    abstract protected function _normalizeTimestamp($timestamp);
}
