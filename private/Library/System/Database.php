<?php

// highly modified, but original source:
// Copyright (c) 2012 Philip Matuskiewicz www.famousphil.com


class System_Database {


    private static $instance;


    public function __construct($config=array()) {
        if (empty($config)) {
            $config = parse_ini_file(_PRIVATE.'config.ini');
        }
        $this->connect($config['mysql_server'], $config['mysql_username'], $config['mysql_password'], $config['mysql_database']);
    }


    public function connect($server, $username, $password, $database) {
        mysql_connect($server, $username, $password);
        mysql_select_db($database);
        $this->query("set names 'utf8'");
    }


    public function query($query){
        return mysql_query($query);
    }


    public function fetchObject($query) {
        $results = $this->fetchObjects($query);
        if (isset($results[0])) {
            return $results[0];
        } else {
            return array();
        }
    }


    public function fetchObjects($query) {
        $result = mysql_query($query);
        $results = array();

        while ($row = mysql_fetch_object($result)) {
            $results[] = $row;
        }
        mysql_free_result($result);
        return $results;
    }


    public function numRows($query){
        return mysql_num_rows($this->query($query));
    }


    public function close() {
        mysql_close();
    }


    public static function singleton(){
        if (!isset(self::$instance)) {
            $c = __class__;
            self::$instance = new $c;
        }
        return self::$instance;
    }


}