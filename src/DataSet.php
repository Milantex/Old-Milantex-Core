<?php
namespace Old\Milantex\Core;

class DataSet {
    private $database;

    public function __construct(\Milantex\DAW\DataBase &$database) {
        $this->database = $database;
    }

    protected function &getDatabase(): \Milantex\DAW\DataBase {
        return $this->database;
    }
}
