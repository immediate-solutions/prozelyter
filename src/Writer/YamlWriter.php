<?php
namespace ImmediateSolutions\Prozelyter\Writer;

use Symfony\Component\Yaml\Yaml;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class YamlWriter extends FilesystemWriter
{
    /**
     * @var string
     */
    private $yml = '';

    /**
     * @var array
     */
    private $headers = [];

    protected function starting()
    {
        //
    }

    /**
     * @param array $headers
     */
    protected function writingHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param array $row
     */
    protected function writingRow(array $row)
    {
        $data = [];

        foreach ($this->headers as $index => $field){
            $data[$field] = $row[$index];
        }

        $this->yml .= Yaml::dump([$data]);
    }

    protected function stopping()
    {
        if (file_put_contents($this->file, $this->yml) === false){
            throw new \RuntimeException('Unable to write yaml into the "'.$this->file.'" file.');
        }

        $this->yml = '';
        $this->headers = [];
    }
}