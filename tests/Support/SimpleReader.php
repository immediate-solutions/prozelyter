<?php
namespace ImmediateSolutions\Prozelyter\Tests\Support;

use ImmediateSolutions\Prozelyter\Reader\ReaderInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SimpleReader implements ReaderInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @param array $headers
     * @param array $data
     */
    public function __construct(array $headers, array $data)
    {
        $this->headers = $headers;
        $this->data = $data;
    }

    public function start()
    {
       //
    }

    /**
     * @return array
     */
    public function readHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array|\Iterator
     */
    public function readRow()
    {
        return $this->data;
    }

    public function stop()
    {
        //
    }
}