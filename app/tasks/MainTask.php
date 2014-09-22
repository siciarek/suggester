<?php

class MainTask extends \Phalcon\CLI\Task {
    public function mainAction() {
        $dbfile = $this->di->getConfig()->dirs->data . DIRECTORY_SEPARATOR . $this->di->get('config')->database->dbname . '.sqlite';

        if (file_exists($dbfile)) {
            unlink($dbfile);
        }
        $sql = file_get_contents($this->di->getConfig()->dirs->config . DIRECTORY_SEPARATOR  . '/schema/sqlitequery.sql');

        $db = new SQLite3($dbfile);
        $db->exec($sql);

        $stmt = $db->prepare('INSERT INTO suggestion_type (name) VALUES (:name);');
        $types = array(
            'error',
            'feature_request',
            'change_request',
            'comment',
            'other',
        );
        foreach ($types as $name) {
            $stmt->bindValue('name', $name);
            $stmt->execute();
        }
    }
}
