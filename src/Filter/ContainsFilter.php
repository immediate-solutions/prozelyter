<?php
namespace ImmediateSolutions\Prozelyter\Filter;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ContainsFilter implements FilterInterface
{
    /**
     * @var string
     */
    private $constraint;

    /**
     * @param string $constraint
     */
    public function __construct($constraint)
    {
        $this->constraint = $constraint;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function allow($value)
    {
        if ($this->constraint === ''){
            return true;
        }

        return strpos(strtolower($value), strtolower($this->constraint)) !== false;
    }
}