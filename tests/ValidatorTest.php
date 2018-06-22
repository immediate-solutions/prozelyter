<?php
namespace ImmediateSolutions\Prozelyter\Tests;

use ImmediateSolutions\Prozelyter\Validator\AsciiValidator;
use ImmediateSolutions\Prozelyter\Validator\RatingValidator;
use ImmediateSolutions\Prozelyter\Validator\UrlValidator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ValidatorTest extends TestCase
{
    public function testAsciiValidator()
    {
        $validator = new AsciiValidator();

        Assert::assertTrue($validator->valid('abc'));
        Assert::assertFalse($validator->valid('§abc'));
    }

    public function testUrlValidator()
    {
        $validator = new UrlValidator();

        Assert::assertTrue($validator->valid('https://test.org/?param=10'));
        Assert::assertFalse($validator->valid('some bad url'));
    }

    public function testRatingValidator()
    {
        $validator = new RatingValidator();

        Assert::assertTrue($validator->valid(0));
        Assert::assertTrue($validator->valid(2));
        Assert::assertTrue($validator->valid(5));

        Assert::assertFalse($validator->valid(-1));
        Assert::assertFalse($validator->valid(6));

        Assert::assertTrue($validator->valid('4'));
        Assert::assertFalse($validator->valid('a'));
    }
}