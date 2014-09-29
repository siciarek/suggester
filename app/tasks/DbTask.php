<?php

define('MYSQL', 'mysql --default-character-set=utf8');

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
                chmod($dbfile, 0664);

                $db->createFunction('MD5', 'md5');
                $db->exec(file_get_contents($this->schema));
                $db->exec(file_get_contents(preg_replace('/sqlite.sql$/', 'fixtures.sql', $this->schema)));
                break;

            default:
                throw new \Exception('Unsupported database adapter: ' . $this->dbconf->adapter);
                break;
        }
    }

    protected function dropDatabase() {

        switch($this->dbconf->adapter) {
            case 'mysql':

                $query = sprintf("DROP DATABASE IF EXISTS %s", $this->dbconf->dbname);

                $cmd = sprintf('%s -h%s -u%s %s -e "%s"',
                    MYSQL,
                    $this->dbconf->host,
                    $this->dbconf->username,
                    $this->dbconf->password ? '-p' . $this->dbconf->password . '' : '',
                    $query
                );

                return $this->runCmd($cmd);

                break;

            case 'sqlite':
                $dbfile = $this->di->getConfig()->dirs->data . DIRECTORY_SEPARATOR . $this->di->get('config')->database->dbname . '.sqlite';
                if (file_exists($dbfile)) {
                    unlink($dbfile);
                }
                break;
        }

    }

    protected function createDatabase()
    {
        $query = sprintf("CREATE DATABASE %s", $this->dbconf->dbname);

        $cmd = sprintf('%s -h%s -u%s %s -e "%s"',
            MYSQL,
            $this->dbconf->host,
            $this->dbconf->username,
            $this->dbconf->password ? '-p' . $this->dbconf->password . '' : '',
            $query
        );

        return $this->runCmd($cmd);
    }

    protected function loadSchema()
    {
        $cmd = sprintf('%s -h%s -u%s %s  -D%s < %s',
            MYSQL,
            $this->dbconf->host,
            $this->dbconf->username,
            $this->dbconf->password ? '-p' . $this->dbconf->password . '' : '',
            $this->dbconf->dbname,
            $this->schema
        );

        $ret = $this->runCmd($cmd);

        $cmd = sprintf('%s -h%s -u%s %s  -D%s < %s',
            MYSQL,
            $this->dbconf->host,
            $this->dbconf->username,
            $this->dbconf->password ? '-p' . $this->dbconf->password . '' : '',
            $this->dbconf->dbname,
            preg_replace('/mysql.sql$/', 'fixtures.sql', $this->schema)
        );

        $ret .= $this->runCmd($cmd);


        return $ret;
    }

    /**
     * @param $cmd
     * @return mixed
     */
    protected function runCmd($cmd)
    {
        echo $cmd . PHP_EOL;
        return `$cmd`;
    }
}