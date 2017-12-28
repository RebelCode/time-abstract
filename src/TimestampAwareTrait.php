<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;

/**
 * Common functionality for objects that are aware of a time instance.
 *
 * @since [*next-version*]
 */
trait TimestampAwareTrait
{
    /**
     * An integer number of seconds since unix epoch.
     *
     * @since [*next-version*]
     *
     * @var int
     */
    protected $timestamp;

    /**
     * Retrieves the timestamp.
     *
     * @since [*next-version*]
     *
     * @return int An integer number of seconds since unix epoch.
     */
    protected function _getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Sets the timestamp.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable $timestamp The number of seconds since unix epoch. Negative numbers are allowed.
     */
    protected function _setTimestamp($timestamp)
    {
        $this->timestamp = $this->_sanitizeTimestamp($timestamp);
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
