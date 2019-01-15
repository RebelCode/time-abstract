<?php

namespace RebelCode\Time;

use Dhii\Time\PeriodInterface;
use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;
use InvalidArgumentException;

/**
 * Common functionality of objects that are aware of a period.
 *
 * @since 0.1
 */
trait PeriodAwareTrait
{
    /**
     * The period instance.
     *
     * @since 0.1
     *
     * @var PeriodInterface|null
     */
    protected $period;

    /**
     * Retrieves the period associated with this instance.
     *
     * @since 0.1
     *
     * @return PeriodInterface|null The period instance, if any.
     */
    protected function _getPeriod()
    {
        return $this->period;
    }

    /**
     * Sets the period for this instance.
     *
     * @since 0.1
     *
     * @param PeriodInterface|null $period The period instance, or null.
     */
    protected function _setPeriod($period)
    {
        if ($period !== null && !($period instanceof PeriodInterface)) {
            throw $this->_createInvalidArgumentException(
                $this->__('Argument is not a valid period'),
                null,
                null,
                $period
            );
        }

        $this->period = $period;
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
