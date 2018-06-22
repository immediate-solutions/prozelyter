<?php
namespace ImmediateSolutions\Prozelyter\Reader;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ReaderInterface
{
    public function start();

    /**
     * @return array
     */
    public function readHeaders();

    /**
     * @return array|null
     */
    public function readRow();

    public function stop();
}