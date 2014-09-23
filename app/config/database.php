<?php

// Set the database service
$di->set('db', function () use ($di) {

    $db = null;
    $dbconfig = $di->getConfig()->database;

    if ($dbconfig->adapter === 'mysql') {
        $db = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            'host' => $di->getConfig()->database->host,
            'username' => $di->getConfig()->database->username,
            'password' => $di->getConfig()->database->password,
            'dbname' => $di->getConfig()->database->dbname,
            'charset' => $di->getConfig()->database->charset,
            'options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8"',
                PDO::ATTR_CASE => PDO::CASE_LOWER
            )
        ));
    } elseif ($dbconfig->adapter === 'sqlite') {
        $dbname = $di->getConfig()->dirs->data . DIRECTORY_SEPARATOR . $di->getConfig()->database->dbname . '.sqlite';

        $db = new \Phalcon\Db\Adapter\Pdo\Sqlite(array(
            'dbname' => $dbname,
        ));
    } else {
        throw new \Exception('Unsupported database adapter: ' . $di->adapter);
    }

    return $db;
});

$di->set('fixtures', function () {

    class Fixtures {
        public function getData($key, $fileName = null) {
            $data_dir = APPLICATION_PATH . '/config/fixtures';
            $fileName = $fileName === null ? $key : $fileName;
            $file = $data_dir . DIRECTORY_SEPARATOR . $fileName . '.yml';

            if (!(is_file($file) === true and is_readable($file) === true)) {
                throw new \Exception('No such file: ' . $file);
            }

            $data = \Symfony\Component\Yaml\Yaml::parse($file);

            if (!(is_array($data) and array_key_exists($key, $data))) {
                throw new \Exception('Invalid data in file: ' . $file);
            }

            return $data[$key];
        }
    }

    return new \Fixtures();
});

$di->set('modelsMetadata', function () use ($di) {

    $metaDataDir = $di->getConfig()->dirs->cache . DIRECTORY_SEPARATOR . 'metadata' . DIRECTORY_SEPARATOR;

    if (!is_dir($metaDataDir)) {
        $umask = umask(0000);
        mkdir($metaDataDir, 0777, true);
        umask($umask);
    }

    $metaData = new \Phalcon\Mvc\Model\Metadata\Files(array(
        'metaDataDir' => $metaDataDir,
    ));

    return $metaData;
});