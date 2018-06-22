<?php
namespace ImmediateSolutions\Prozelyter\Validator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UrlValidator implements ValidatorInterface
{
    /**
     * @param string $value
     * @return bool
     */
    public function valid($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }
}