<?php

define('MYSQL', 'mysql');

class DbTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
        echo $this->dropDatabase();
        echo $this->createDatabase();
        echo $this->loadSchema();
    }

    protected function dropDatabase() {

        $dbconf = Phalcon\DI::getDefault()->getConfig()->database;

        $query = sprintf("DROP DATABASE IF EXISTS `%s`", $dbconf->dbname);

        $cmd = sprintf('%s -u"%s" %s -e "%s"',
            MYSQL,
            $dbconf->username,
            $dbconf->password ? '-p "' . $dbconf->password . '"' : '',
            $query
        );

        return `$cmd`;
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
            realpath(APPLICATION_PATH . '/config/schema/query.sql')
        );

        return `$cmd`;
    }
}
