<?php

class EventDAOFactory{
    private static $instance;
    private $eventDAO;
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }

        return self::$instance;
    }

   public function createDAO($dbname){
        if(empty($this->eventDAO)){
                $db = new PDO('mysql:host=localhost;dbname=test_db;charset=utf8', 'root', '123');
                $this->eventDAO = new EventDAO($db);
        }
        return $this->eventDAO;
   }
}

