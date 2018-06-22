<?php
namespace ImmediateSolutions\Prozelyter\Writer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SqliteWriter extends FilesystemWriter
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var bool
     */
    private $tableCreated = false;

    protected function starting()
    {
        $this->pdo = new \PDO('sqlite:' . $this->file);

        $this->pdo->exec('DROP TABLE IF EXISTS rows');
    }

    protected function writingHeaders(array $headers)
    {
        $columns = '';
        $d = '';

        foreach ($headers as $header){
            $columns .= $d.'`'.$header.'` TEXT';
            $d = ',';
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS rows('.$columns.')');

        $this->tableCreated = true;
    }

    /**
     * @param array $row
     */
    protected function writingRow(array $row)
    {
        if (!$this->tableCreated){
            throw new \RuntimeException('The table has not been created yet');
        }

        if (!$this->pdo->inTransaction()){
            $this->pdo->beginTransaction();
        }

        $placeholders = implode(',', array_pad([], count($row), '?'));

        $this->pdo->prepare('INSERT INTO rows VALUES ('.$placeholders.')')->execute($row);
    }

    protected function stopping()
    {
        if ($this->pdo->inTransaction()){
            $this->pdo->commit();
        }

        $this->tableCreated = false;
    }
}