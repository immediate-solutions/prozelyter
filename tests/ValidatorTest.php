<?php
namespace ImmediateSolutions\Prozelyter\Tests;

use ImmediateSolutions\Prozelyter\Validator\UrlValidator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ValidatorTest extends TestCase
{
    public function testUrlValidator()
    {
        $validator = new UrlValidator();

        Assert::assertTrue($validator->valid('https://test.org/?param=10'));
        Assert::assertFalse($validator->valid('some bad url'));
    }
}