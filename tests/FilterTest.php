<?php
namespace ImmediateSolutions\Prozelyter\Tests;

use ImmediateSolutions\Prozelyter\Filter\ContainsFilter;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FilterTest extends TestCase
{
    public function testContainsFilter()
    {
        $filter = new ContainsFilter('Bcd');

        Assert::assertTrue($filter->allow('AbCdeF'));
        Assert::assertTrue($filter->allow('bCd'));

        Assert::assertFalse($filter->allow('AbC'));

        $filter = new ContainsFilter('');
        Assert::assertTrue($filter->allow('any string'));
    }
}