<?php

class Database
{
    
    private static $dbHost = "localhost";
    private static $dbName = "burger";
    private static $dbUser = "root";
    private static $dbUserPassword = "";

    private static  $connexion = null;

    public static function connect()
    {
        try
        {
            self::$connexion = new PDO("mysql:host=". self::$dbHost . ";dbname=" . self::$dbName,self::$dbUser,self::$dbUserPassword);
            self::$connexion->query("SET NAMES UTF8");
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
        return  self::$connexion;
    }

    public static function disconnect()
    {
        self::$connexion = null;
    }
    
}

Database::connect();
    

?>