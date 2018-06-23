<?php
namespace ImmediateSolutions\Prozelyter;

use ImmediateSolutions\Prozelyter\Filter\FilterInterface;
use ImmediateSolutions\Prozelyter\Reader\ReaderInterface;
use ImmediateSolutions\Prozelyter\Validator\ValidatorInterface;
use ImmediateSolutions\Prozelyter\Writer\WriterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Converter
{
    /**
     * @var ValidatorInterface[]
     */
    private $validators = [];

    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * @var ReaderInterface[]
     */
    private $readers = [];

    /**
     * @var WriterInterface[]
     */
    private $writers = [];

    /**
     * @param string $format
     * @param WriterInterface $writer
     */
    public function addWriter($format, WriterInterface $writer)
    {
        $this->writers[$format] = $writer;
    }

    /**
     * @param string $format
     * @param ReaderInterface $reader
     */
    public function addReader($format, ReaderInterface $reader)
    {
        $this->readers[$format] = $reader;
    }

    /**
     * @param string $field
     * @param ValidatorInterface $validator
     */
    public function addValidator($field, ValidatorInterface $validator)
    {
        if (!isset($this->validators[$field])){
            $this->validators[$field] = [];
        }

        $this->validators[$field][] = $validator;
    }

    /**
     * @param string $field
     * @param FilterInterface $filter
     */
    public function addFilter($field, FilterInterface $filter)
    {
        if (!isset($this->filters[$field])){
            $this->filters[$field] = [];
        }

        $this->filters[$field][] = $filter;
    }

    /**
     * @param string|ReaderInterface $from
     * @param string|WriterInterface $to
     */
    public function convert($from, $to)
    {
        if ($from instanceof ReaderInterface) {
            $reader = $from;
        } elseif (is_string($from)) {
            if (!isset($this->readers[$from])) {
                throw new \RuntimeException('Can\'t find reader for "'.$from.'"');
            }

            $reader = $this->readers[$from];
        } else {
            throw new \RuntimeException('Invalid value is provided for "from"');
        }

        if ($to instanceof WriterInterface) {
            $writer = $to;
        } elseif (is_string($to)) {
            if (!isset($this->writers[$to])) {
                throw new \RuntimeException('Can\'t find writer for "'.$to.'"');
            }

            $writer = $this->writers[$to];
        } else {
            throw new \RuntimeException('Invalid value is provided for "to"');
        }

        $reader->start();
        $writer->start();

        $headers = $reader->readHeaders();

        $writer->writeHeaders($headers);

        while (($row = $reader->readRow()) !== null){

            if (!$this->valid($headers, $row)){
                continue ;
            }

            if (!$this->allow($headers, $row)){
                continue ;
            }

            $writer->writeRow($row);
        }

        $reader->stop();
        $writer->stop();
    }

    /**
     * @param array $headers
     * @param array $row
     * @return bool
     */
    private function allow(array $headers, array $row)
    {
        foreach ($headers as $index => $field){

            if (isset($this->filters[$field])) {
                $value = $row[$index];

                /**
                 * @var FilterInterface[] $filters
                 */
                $filters = $this->filters[$field];

                foreach ($filters as $filter) {
                    if (!$filter->allow($value)){
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * @param array $headers
     * @param array $row
     * @return bool
     */
    private function valid(array $headers, array $row)
    {
        foreach ($headers as $index => $field){

            if (isset($this->validators[$field])) {

                $value = $row[$index];

                /**
                 * @var ValidatorInterface[] $validators
                 */
                $validators = $this->validators[$field];

                foreach ($validators as $validator) {
                    if (!$validator->valid($value)){
                        return false;
                    }
                }
            }
        }

        return true;
    }
}