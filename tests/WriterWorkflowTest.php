<?php
namespace ImmediateSolutions\Prozelyter\Tests;

use ImmediateSolutions\Prozelyter\Tests\Support\SimpleWriter;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class WriterWorkflowTest extends TestCase
{
    public function testDefault()
    {
        $writer = new SimpleWriter();

        $writer->start();

        $writer->writeHeaders(['h1', 'h2', 'h3']);
        $writer->writeRow([1, 2, 3]);
        $writer->writeRow([4, 5, 6]);

        $writer->stop();

        $merged = $writer->getMerged();

        Assert::assertEquals(['h1', 'h2', 'h3'], $merged[0]);
        Assert::assertEquals([1, 2, 3], $merged[1]);
        Assert::assertEquals([4, 5, 6], $merged[2]);

        //

        $writer->start();

        $writer->writeHeaders(['c1', 'c2', 'c3']);
        $writer->writeRow(['a', 'b', 'c']);

        $merged = $writer->getMerged();

        Assert::assertEquals([], $merged);

        $writer->stop();

        $merged = $writer->getMerged();

        Assert::assertEquals(['c1', 'c2', 'c3'], $merged[0]);
        Assert::assertEquals(['a', 'b', 'c'], $merged[1]);
    }

    public function testInvalidWorkflow1()
    {
        $this->expectExceptionMessage('The writer is not started');

        $writer = new SimpleWriter();

        $writer->writeHeaders(['h1', 'h2', 'h3']);
    }

    public function testInvalidWorkflow2()
    {
        $this->expectExceptionMessage('The writer is not started');

        $writer = new SimpleWriter();

        $writer->writeRow([1, 2, 3]);
    }
}