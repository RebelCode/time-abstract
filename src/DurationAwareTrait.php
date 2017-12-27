<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;

/**
 * Common functionality for objects that are aware of a duration.
 *
 * @since [*next-version*]
 */
trait DurationAwareTrait
{
    /**
     * An integer number of seconds.
     *
     * @since [*next-version*]
     *
     * @var int
     */
    protected $duration;

    /**
     * Retrieves the timestamp.
     *
     * @since [*next-version*]
     *
     * @return int An integer number of seconds since unix epoch.
     */
    protected function _getDuration()
    {
        return $this->duration;
    }

    /**
     * Sets the duration for this instance.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable $duration The number of seconds since unix epoch.
     */
    protected function _setDuration($duration)
    {
        $this->duration = $this->_normalizeTimestamp($duration);
    }

    /**
     * Normalizes a timestamp value.
     *
     * @since [*next-version*]
     *
     * @param int|string|Stringable $timestamp The timestamp.
     *
     * @return int The normalized timestamp.
     */
    abstract protected function _normalizeTimestamp($timestamp);
}