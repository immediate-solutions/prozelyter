<?php
namespace ImmediateSolutions\Prozelyter\Writer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class JsonWriter extends FilesystemWriter
{
    /**
     * @var string
     */
    private $json = '';

    /**
     * @var array
     */
    private $headers = [];

    protected function starting()
    {
        $this->json = '[';
    }

    /**
     * @param array $headers
     */
    protected function writingHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    protected function writingRow(array $row)
    {
        $data = [];

        foreach ($this->headers as $index => $field){
            $data[$field] = $row[$index];
        }

        $delimiter = $this->json == '[' ? '' : ',';

        $this->json .= $delimiter.json_encode($data);
    }

    protected function stopping()
    {
        $this->json .= ']';

        if (file_put_contents($this->file, $this->json) === false){
            throw new \RuntimeException('Unable to write json into the "'.$this->file.'" file.');
        }

        $this->json = '';
        $this->headers = [];
    }
}