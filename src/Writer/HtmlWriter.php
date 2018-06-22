<?php
namespace ImmediateSolutions\Prozelyter\Writer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class HtmlWriter extends FilesystemWriter
{
    /**
     * @var string
     */
    private $html = '';

    /**
     * @var string
     */
    private $headers = '';

    /**
     * @var string
     */
    private $rows = '';


    protected function starting()
    {
        $this->html = '<html><body><table>';
    }

    protected function writingHeaders(array $headers)
    {
        $this->headers = '';

        foreach ($headers as $text){
            $this->headers .= '<th>'.htmlentities($text).'</th>';
        }
    }

    /**
     * @param array $row
     */
    protected function writingRow(array $row)
    {
        $this->rows .= '<tr>';

        foreach ($row as $value) {
            $this->rows .= '<td>'.htmlentities($value).'</td>';
        }

        $this->rows .= '</tr>';
    }

    protected function stopping()
    {
        $this->html .= $this->headers;
        $this->html .= $this->rows;
        $this->html .= '</table></body></html>';

        if (file_put_contents($this->file, $this->html) === false){
            throw new \RuntimeException('Unable to write html into the "'.$this->file.'" file.');
        }

        $this->html = '';
        $this->headers = '';
        $this->rows = '';
    }
}