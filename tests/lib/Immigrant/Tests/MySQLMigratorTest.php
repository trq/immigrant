<?php

namespace Immigrant\Tests;

use Immigrant;

class MySQLMigratorTest extends \PHPUnit_Framework_TestCase
{
    private $migrator;

    public function setUp()
    {
        $config = include 'config.php';
        $this->migrator = new Immigrant\MySQLMigrator(new \PDO($config['dsn'], $config['user'], $config['pass']));
        $this->migrator->begin();
    }

    public function tearDown()
    {
        $this->migrator->commit();
    }

    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Immigrant\MySQLMigrator', $this->migrator);
    }

    public function testDatabaseExists()
    {
        $this->assertTrue($this->migrator->databaseExists('information_schema'));
    }

    /**
     * @depends testDatabaseExists
     */
    public function testCanCreateDatabase()
    {
        $this->migrator->createDatabase('immigrant_test');
        $this->assertTrue($this->migrator->databaseExists('immigrant_test'));
    }

    /**
     * @depends testCanCreateDatabase
     * @expectedException RuntimeException
     */
    public function testFailToCreateExistingDatabase()
    {
        $this->migrator->createDatabase('immigrant_test');
    }

    /**
     * @depends testCanCreateDatabase
     */
    public function testCanDropDatabase()
    {
        $this->migrator->dropDatabase('immigrant_test');
        $this->assertFalse($this->migrator->databaseExists('immigrant_test'));
    }
}
