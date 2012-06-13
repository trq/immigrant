<?php

namespace Immigrant;

interface MigratorInterface
{

    public function databaseExists($db);
    public function createDatabase($database, array $options = array());
    public function dropDatabase($database);

    public function tableExists($table);
    public function createTable($table, array $options = array());
    public function dropTable($table);
    public function renameTable($old, $new);

    public function columnExists($column);
    public function createColumn($column, array $options = array());
    public function dropColumn($column);
    public function renameColumn($old, $new);
    public function editColumn($column, array $options = array());

    public function indexExists($index);
    public function createIndex($table, $column, array $options = array());
    public function dropIndex($table, $column);

}
