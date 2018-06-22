<?php
namespace ImmediateSolutions\Prozelyter\Reader;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CsvReader implements ReaderInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var resource
     */
    private $handler;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var bool
     */
    private $started = false;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function start()
    {
        if ($this->started){
            $this->stop();
        }

        $this->handler = fopen($this->file, 'r');

        if ($this->handler === false) {
            throw new \RuntimeException('Unable to read the "'.$this->file.'" file.');
        }

        $this->started = true;
    }

    /**
     * @return array|null
     */
    public function readRow()
    {
        $this->checkIfStarted();

        $row = fgetcsv($this->handler);

        return $row !== false ? $row : null;
    }

    /**
     * @return array
     */
    public function readHeaders()
    {
        $this->checkIfStarted();

        $this->headers = fgetcsv($this->handler);

        if (!$this->headers){

            $this->stop();

            throw new \RuntimeException('Unable read the header of the "'.$this->file.'" file.');
        }

        return $this->headers;
    }

    private function checkIfStarted()
    {
        if (!$this->started){
            throw new \RuntimeException('The reader is not started');
        }
    }

    public function stop()
    {
        if (!$this->started){
            return ;
        }

        fclose($this->handler);

        $this->started = false;
        $this->handler = null;
        $this->headers = null;
    }
}