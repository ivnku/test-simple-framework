<?php

namespace TestFramework\Core;

use PDO;
use TestFramework\App\Config as Cfg;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            try {                
                $dsn = "mysql:host=" . Cfg::DB_HOST . ";dbname=" . Cfg::DB_NAME . ";charset=utf8"; 
                $db = new PDO($dsn, Cfg::DB_USER, Cfg::DB_PASS);
                
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $db;
                
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}