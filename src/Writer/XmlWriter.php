<?php
namespace ImmediateSolutions\Prozelyter\Writer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class XmlWriter extends FilesystemWriter
{
    /**
     * @var \XMLWriter
     */
    private $xml;

    /**
     * @var array
     */
    private $headers = [];

    protected function starting()
    {
        $this->xml = new \XMLWriter();

        $this->xml->openURI($this->file);
        $this->xml->startDocument('1.0','UTF-8');
        $this->xml->startElement('rows');
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
        $this->xml->startElement('row');

        foreach ($this->headers as $index => $field){

            $this->xml->startElement($field);

            $this->xml->text($row[$index]);

            $this->xml->endElement();
        }

        $this->xml->endElement();
    }

    protected function stopping()
    {
        $this->xml->endElement();
        $this->xml->endDocument();

        $this->xml->flush();

        $this->headers = [];
    }
}