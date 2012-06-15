<?php

class Table
{
    public function __construct($t)
    {
        echo $t;
    }

    public function addColumn($c)
    {
        return new Column($this, $c);
    }

    public function addIndex($i)
    {
        return new Index($this, $i);
    }

    public function commit()
    {
        echo "COMMIT\n";
        return $this;
    }
}

class Column
{
    private $table;
    public function __construct($table, $c)
    {
        $this->table = $table;
        echo $c;
    }

    public function type($t)
    {
        echo $t;
        return $this;
    }

    public function length($l)
    {
        echo $l;
        return $this;
    }

    public function commit()
    {
        echo " ";
        return $this->table;
    }
}

class Index
{
    private $table;
    public function __construct($table, $i)
    {
        $this->table = $table;
        echo $i;
    }

    public function commit()
    {
        echo " ";
        return $this->table;
    }
}

class SomeMigration
{
    public function createTable($t)
    {
        return new Table($t);
    }

    public function up()
    {
        $this->createTable('users')->commit()
            ->addColumn('username')->type('text')->length(40)->commit()
            ->addColumn('password')->type('text')->length(40)->commit()
            ->addIndex('some-index')->commit()
            ->addColumn('created')->type('datetime')->commit()
        ;
    }

    public function down()
    {

    }
}

(new SomeMigration)->up();
