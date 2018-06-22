<?php
namespace ImmediateSolutions\Prozelyter\Filter;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface FilterInterface
{
    /**
     * @param string $value
     * @return bool
     */
    public function allow($value);
}