<?php

namespace RebelCode\Time;

use Dhii\Util\String\StringableInterface as Stringable;

/**
 * Common functionality for objects that are aware of a duration.
 *
 * @since 0.1
 */
trait DurationAwareTrait
{
    /**
     * An integer number of seconds.
     *
     * @since 0.1
     *
     * @var int
     */
    protected $duration;

    /**
     * Retrieves the duration associated with this instance.
     *
     * @since 0.1
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
     * @since 0.1
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
     * @since 0.1
     *
     * @param int|string|Stringable $timestamp The timestamp.
     *
     * @return int The normalized timestamp.
     */
    abstract protected function _normalizeTimestamp($timestamp);
}
