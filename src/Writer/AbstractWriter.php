<?php
namespace ImmediateSolutions\Prozelyter\Writer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractWriter implements WriterInterface
{
    /**
     * @var bool
     */
    private $started = false;


    public function start()
    {
        if ($this->started){
            $this->stop();
        }

        $this->starting();

        $this->started = true;
    }

    abstract protected function starting();

    /**
     * @param array $headers
     */
    public function writeHeaders(array $headers)
    {
        $this->checkIfStarted();

        $this->writingHeaders($headers);
    }

    abstract protected function writingHeaders(array $headers);

    /**
     * @param array $row
     */
    public function writeRow(array $row)
    {
        $this->checkIfStarted();

        $this->writingRow($row);
    }

    /**
     * @param array $row
     */
    abstract protected function writingRow(array $row);

    public function stop()
    {
        if (!$this->started) {
            return ;
        }

        $this->stopping();

        $this->started = false;
    }

    abstract protected function stopping();

    private function checkIfStarted()
    {
        if (!$this->started){
            throw new \RuntimeException('The writer is not started');
        }
    }
}