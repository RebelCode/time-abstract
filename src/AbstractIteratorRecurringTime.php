<?php

namespace RebelCode\Time;

use Dhii\Time\IntervalInterface;
use Dhii\Time\PeriodInterface;
use Dhii\Time\TimeInterface;

/**
 * Abstract functionality for recurring time instances that implement iterator-like behaviour.
 *
 * @since 0.1
 */
abstract class AbstractIteratorRecurringTime
{
    /**
     * A temporary iteration cursor representing the timestamp of the current item.
     *
     * @since 0.1
     *
     * @var int
     */
    protected $cursorTime;

    /**
     * Resets iteration.
     *
     * @since 0.1
     */
    protected function _reset()
    {
        $this->cursorTime = $this->_getPeriod()->getStart()->getTimestamp();
    }

    /**
     * Checks if the iteration is still valid.
     *
     * @since 0.1
     *
     * @return bool True if the iteration is valid and can continue, false if the end has been reached.
     */
    protected function _valid()
    {
        return $this->cursorTime <= $this->_getPeriod()->getEnd()->getTimestamp();
    }

    /**
     * Retrieves the current iteration value.
     *
     * @since 0.1
     *
     * @return TimeInterface The current iteration time instance.
     */
    protected function _current()
    {
        return $this->_createTime($this->cursorTime);
    }

    /**
     * Retrieves the key of the current iteration value.
     *
     * @since 0.1
     *
     * @return int The timestamp of the current iteration time instance.
     */
    protected function _key()
    {
        return $this->cursorTime;
    }

    /**
     * Advances the iteration forward by the interval.
     *
     * @since 0.1
     */
    protected function _next()
    {
        $this->cursorTime += $this->_getInterval()->getDuration();
    }

    /**
     * Retrieves the period of time in which the time recurs.
     *
     * @since 0.1
     *
     * @return PeriodInterface The period of time.
     */
    abstract protected function _getPeriod();

    /**
     * Retrieves the interval between recurring times.
     *
     * @since 0.1
     *
     * @return IntervalInterface The interval.
     */
    abstract protected function _getInterval();

    /**
     * Creates a new time instance.
     *
     * @since 0.1
     *
     * @param int $timestamp The timestamp.
     *
     * @return TimeInterface The created time instance.
     */
    abstract protected function _createTime($timestamp);
}
