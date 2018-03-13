<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;
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
     *
     * @throws InvalidArgumentException If the given value is not a valid timestamp.
     */
    protected function _setStart($start)
    {
        $this->start = $this->_normalizeTimestamp($start);
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
