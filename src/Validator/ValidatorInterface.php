<?php
namespace ImmediateSolutions\Prozelyter\Validator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * @param string $value
     * @return bool
     */
    public function valid($value);
}