<?php

namespace RebelCode\Time;

use Dhii\Time\IntervalInterface;
use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;
use InvalidArgumentException;

/**
 * Common functionality for objects that are aware of an interval.
 *
 * @since 0.1
 */
trait IntervalAwareTrait
{
    /**
     * The interval instance.
     *
     * @since 0.1
     *
     * @var IntervalInterface
     */
    protected $interval;

    /**
     * Retrieves the interval associated with this instance.
     *
     * @since 0.1
     *
     * @return IntervalInterface|null
     */
    protected function _getInterval()
    {
        return $this->interval;
    }

    /**
     * Sets the interval for this instance.
     *
     * @since 0.1
     *
     * @param IntervalInterface|null $interval
     */
    protected function _setInterval($interval)
    {
        if ($interval !== null && !($interval instanceof IntervalInterface)) {
            throw $this->_createInvalidArgumentException(
                $this->__('Argument is not a valid interval'),
                null,
                null,
                $interval
            );
        }

        $this->interval = $interval;
    }

    /**
     * Creates a new invalid argument exception.
     *
     * @since 0.1
     *
     * @param string|Stringable|null $message  The error message, if any.
     * @param int|null               $code     The error code, if any.
     * @param RootException|null     $previous The inner exception for chaining, if any.
     * @param mixed|null             $argument The invalid argument, if any.
     *
     * @return InvalidArgumentException The new exception.
     */
    abstract protected function _createInvalidArgumentException(
        $message = null,
        $code = null,
        RootException $previous = null,
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
