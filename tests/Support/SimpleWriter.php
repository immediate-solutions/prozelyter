<?php
namespace ImmediateSolutions\Prozelyter\Tests\Support;

use ImmediateSolutions\Prozelyter\Writer\AbstractWriter;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SimpleWriter extends AbstractWriter
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $rows = [];

    /**
     * @var array
     */
    private $merged = [];

    protected function starting()
    {
        $this->merged = [];
    }

    protected function writingHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param array $row
     */
    protected function writingRow(array $row)
    {
       $this->rows[] = $row;
    }

    protected function stopping()
    {
        $this->merged = array_merge([$this->headers], $this->rows);

        $this->headers = [];
        $this->rows = [];
    }

    /**
     * @return array
     */
    public function getMerged()
    {
        return $this->merged;
    }
}