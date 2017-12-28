<?php

namespace RebelCode\Time;

use Dhii\Time\TimeInterface;

/**
 * Abstract common functionality for periods of time.
 *
 * @since [*next-version*]
 */
abstract class AbstractPeriod
{
    /**
     * Retrieves the start time of this period.
     *
     * @since [*next-version*]
     *
     * @return TimeInterface
     */
    abstract protected function _getStart();

    /**
     * Retrieves the end time of this period.
     *
     * @since [*next-version*]
     *
     * @return TimeInterface
     */
    abstract protected function _getEnd();

    /**
     * Retrieves the duration of this period.
     *
     * @since [*next-version*]
     *
     * @return int An integer number of seconds.
     */
    protected function _getDuration()
    {
        return $this->_getEnd()->getTimestamp() - $this->_getStart()->getTimestamp();
    }
}
