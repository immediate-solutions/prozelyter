<?php
namespace ImmediateSolutions\Prozelyter\Writer;


/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface WriterInterface
{
    public function start();

    /**
     * @param array $headers
     */
    public function writeHeaders(array $headers);

    /**
     * @param array $row
     */
    public function writeRow(array $row);

    public function stop();
}