<?php
namespace ImmediateSolutions\Prozelyter\Tests;

use ImmediateSolutions\Prozelyter\Converter;
use ImmediateSolutions\Prozelyter\Filter\ContainsFilter;
use ImmediateSolutions\Prozelyter\Tests\Support\SimpleReader;
use ImmediateSolutions\Prozelyter\Tests\Support\SimpleWriter;
use ImmediateSolutions\Prozelyter\Validator\AsciiValidator;
use ImmediateSolutions\Prozelyter\Validator\RatingValidator;
use ImmediateSolutions\Prozelyter\Validator\UrlValidator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ConverterTest extends TestCase
{
    public function testConvert()
    {
        $reader = new SimpleReader(['h1', 'h2', 'h3'], [
            [1, 2, 3],
            [4, 5, 6]
        ]);

        $writer = new SimpleWriter();

        $converter = new Converter($reader, $writer);

        $converter->convert();

        $merged = $writer->getMerged();

        Assert::assertEquals(['h1', 'h2', 'h3'], $merged[0]);
        Assert::assertEquals([1, 2, 3], $merged[1]);
        Assert::assertEquals([4, 5, 6], $merged[2]);
    }

    public function testConvertWithValidatorsAndFilters()
    {
        $reader = new SimpleReader(['name', 'url', 'stars', 'description'], [
            ['Hotel A', 'http://hotel-a.com', '3', 'text a'],
            ['Hotel B', 'http://hotel-b.com', 10, 'text b'],
            ['Hotel C', 'http://hotel-c.com', '0', 'text c'],
            ['Hotel D', 'hotel-c.com', 4, 'text d'],
            ['Hotel § E', 'https://hotel-e.com', 1, 'text e'],

        ]);

        $writer = new SimpleWriter();

        $converter = new Converter($reader, $writer);

        $converter->addValidator('name', new AsciiValidator());
        $converter->addValidator('url', new UrlValidator());
        $converter->addValidator('stars', new RatingValidator());

        $converter->convert();

        $merged = $writer->getMerged();

        Assert::assertEquals(['name', 'url', 'stars', 'description'], $merged[0]);

        Assert::assertCount(3, $merged);

        Assert::assertEquals(['Hotel A', 'http://hotel-a.com', '3', 'text a'], $merged[1]);
        Assert::assertEquals(['Hotel C', 'http://hotel-c.com', '0', 'text c'], $merged[2]);

        $converter->addFilter('name', new ContainsFilter('tel a'));

        $converter->convert();

        $merged = $writer->getMerged();

        Assert::assertCount(2, $merged);

        Assert::assertEquals(['Hotel A', 'http://hotel-a.com', '3', 'text a'], $merged[1]);
    }
}