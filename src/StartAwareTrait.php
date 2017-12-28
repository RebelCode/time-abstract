<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;

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
}
