<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//class ZeModel extends ActiveRecord\Model {
class ZeDatabase
{
    /**
     * @var Singleton
     * @access private
     * @static
     */
    private static $_instance = null;
    private $connexions = array() ;

    public function __construct()
    {

    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new ZeDatabase();
        }

        return self::$_instance;
    }

    public function open($dbConfig = "default") {
        global $db ;

        if (isset($connexions[$dbConfig])) {
            return $connexions[$dbConfig] ;
        } else {
            if (isset($db[$dbConfig])) {

                // connexion with PDO
                $dsn = $db[$dbConfig]["dbdriver"] . ':dbname=' . $db[$dbConfig]["database"] . ';host=' . $db[$dbConfig]["hostname"];

                if (isset($db[$dbConfig]["char_set"])) {
                    $dsn .= ";charset=" . $db[$dbConfig]["char_set"] ;

                }

                $user = $db[$dbConfig]["username"];
                $password = $db[$dbConfig]["password"];

                try {
                    $connexions[$dbConfig] = new PDO($dsn, $user, $password);
                    return $connexions[$dbConfig] ;
                } catch (PDOException $e) {
                    throw new Exception('Not connected : ' . $e->getMessage());
                }
            } else {
                throw new Exception('DB Config not exists');
            }
        }

        return null ;
    }
}

