<?php

namespace Immigrant;

class MySQLMigrator implements MigratorInterface
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function begin()
    {
        $this->db->beginTransaction();
    }

    public function commit()
    {
        $this->db->commit();
    }

    public function rollback()
    {
        $this->db->rollback();
    }

    public function inTransaction()
    {
        return $this->db->inTransaction();
    }

    public function databaseExists($db)
    {
        $s = $this->db->prepare('
            SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname
        ');

        $s->bindParam(':dbname', $db);
        $s->execute();

        return $s->fetchColumn() ? true : false;
    }

    public function createDatabase($database, array $options = array()) {
        if ($this->databaseExists($database)) {
            throw new \RuntimeException(sprintf("The database %s already exists, unable to create.", $database));
        }

        $ops = array_merge(array(
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci'
        ), $options);

        $s = $this->db->exec("
            CREATE DATABASE {$database}
            CHARACTER SET {$ops['charset']}
            COLLATE {$ops['collation']}
        ");

        return $this;
    }

    public function dropDatabase($database) {
        if (!$this->databaseExists($database)) {
            throw new \RuntimeException(sprintf("The database %s does not exist, unable to drop.", $database));
        }

        $s = $this->db->exec("DROP DATABASE {$database}");

        return $this;
    }

    public function tableExists($table) {}
    public function createTable($table, array $options = array()) {}
    public function dropTable($table) {}
    public function renameTable($old, $new) {}

    public function columnExists($column) {}
    public function createColumn($column, array $options = array()) {}
    public function dropColumn($column) {}
    public function renameColumn($old, $new) {}
    public function editColumn($column, array $options = array()) {}

    public function indexExists($index) {}
    public function createIndex($table, $column, array $options = array()) {}
    public function dropIndex($table, $column) {}

}
