<?php

define('MYSQL', 'mysql');

class DbTask extends \Phalcon\CLI\Task
{
    /**
     * @var \Phalcon\Config
     */
    protected $dbconf;

    /**
     * @var string
     */
    protected $schema;
    protected $sql;

    public function mainAction()
    {
        $this->dbconf = Phalcon\DI::getDefault()->getConfig()->database;
        $file = $this->getDI()->getConfig()->dirs->config . DIRECTORY_SEPARATOR  . 'schema' . DIRECTORY_SEPARATOR  . $this->dbconf->adapter . '.sql';
        $this->schema = realpath($file);
        $this->sql = file_get_contents($this->schema);

        if($this->schema === false) {
            throw new \Exception('Unsupported database adapter: ' . $this->dbconf->adapter);
        }

        echo "{$this->dbconf->adapter}\n";

        echo $this->dropDatabase();

        switch($this->dbconf->adapter) {
            case 'mysql':

                echo $this->createDatabase();
                echo $this->loadSchema();

                break;

            case 'sqlite':

                $dbfile = $this->di->getConfig()->dirs->data . DIRECTORY_SEPARATOR . $this->di->get('config')->database->dbname . '.sqlite';
                $db = new SQLite3($dbfile);
                $db->exec($this->sql);
                break;

            default:
                throw new \Exception('Unsupported database adapter: ' . $this->dbconf->adapter);
                break;
        }
    }

    protected function dropDatabase() {

        switch($this->dbconf->adapter) {
            case 'mysql':

                $query = sprintf("DROP DATABASE IF EXISTS `%s`", $this->dbconf->dbname);

                $cmd = sprintf('%s -u"%s" %s -e "%s"',
                    MYSQL,
                    $this->dbconf->username,
                    $this->dbconf->password ? '-p "' . $this->dbconf->password . '"' : '',
                    $query
                );

                return `$cmd`;

                break;

            case 'sqlite':
                $dbfile = $this->di->getConfig()->dirs->data . DIRECTORY_SEPARATOR . $this->di->get('config')->database->dbname . '.sqlite';
                if (file_exists($dbfile)) {
                    unlink($dbfile);
                }
                break;
        }

    }

    protected function createDatabase() {

        $dbconf = Phalcon\DI::getDefault()->getConfig()->database;

        $query = sprintf("CREATE DATABASE `%s`", $dbconf->dbname);

        $cmd = sprintf('%s -u"%s" %s -e "%s"',
            MYSQL,
            $dbconf->username,
            $dbconf->password ? '-p "' . $dbconf->password . '"' : '',
            $query
        );

        return `$cmd`;
    }

    protected function loadSchema() {

        $dbconf = Phalcon\DI::getDefault()->getConfig()->database;

        $cmd = sprintf('%s -u"%s" %s -D"%s" < %s',
            MYSQL,
            $dbconf->username,
            $dbconf->password ? '-p "' . $dbconf->password . '"' : '',
            $dbconf->dbname,
            $this->schema
        );

        return `$cmd`;
    }
}
