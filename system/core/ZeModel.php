<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeModel {
    public static $_load = null ;
    protected $load = null ;
    public static $_dbConfig = null ;
    protected $dbConfig = null ;
    private $_ctrl = null;
    private $_db = null ;
    protected $table_name = '' ;
    protected $_fields = array() ;
    protected $_primary_key = null ;

    public function __construct($dbConfig = "default") {
        $this->load = self::$_load ;

        if (self::$_dbConfig == null) {
            self::$_dbConfig = $dbConfig ;
        }

        $this->dbConfig = self::$_dbConfig ;



        // get all fields
        $this->_fields = $this->database()->table($this->table_name)->getColumnName() ;


        // define all fields
        foreach ($this->_fields as $field) {
            $this->$field = null ;
        }

        $this->_primary_key = $this->database()->table($this->table_name)->getPrimaryKey() ;
    }

    public function setDb($dbConfig) {
        self::$_dbConfig = $dbConfig ;
        $this->database()->setDb($dbConfig) ;
    }


    public function database() {
        // open connexion if necessary
        if ($this->_db == null) {
            $this->_db = new ZeQuery() ;
            $this->_db->setDb() ;
        }

        return $this->_db ;
    }

    public function get($where = array()) {
        if($res = $this->database()->table($this->table_name)->where($where)->result())
            return $res[0];
        else
            return $res;
    }

    public function all($where = array()) {
        return $this->database()->table($this->table_name)->where($where)->result();
    }

    public function delete($arrData) {
        $this->database()->clearSql() ;
        return $this->database()->table($this->table_name)->delete($arrData);
    }

    public function save() {
        $this->database()->clearSql() ;

        if ($this->_primary_key) {
            $primaryKey = $this->_primary_key ;
            if ($this->$primaryKey) {
                $this->update(array($primaryKey=>$this->$primaryKey)) ;
            } else {
                $this->insert() ;
            }
        } else {
            throw new Exception('No primary is define in table : ' . $this->table_name);
        }
    }

    public function insert() {
        $this->database()->clearSql() ;

        $pdoStat = $this->database()->table($this->table_name) ;

        foreach ($this->_fields as $field) {

            if ($field == "created_at") {
                $this->$field = date("Y-m-d H:i:s") ;
            } elseif ($field == "updated_at") {
                $this->$field = date("Y-m-d H:i:s") ;
            }

            $pdoStat->insertNewField($field, $this->$field) ;
        }

        // insert le contenu
        $pdoStat->create();
    }

    public function update($where, $objData = null) {
        $this->database()->clearSql() ;

        $pdoStat = $this->database()->table($this->table_name) ;


        // copie all data to object
        if ($objData) {
            foreach ($this->_fields as $field) {
                if (isset($objData->$field)) {
                    $this->$field = $objData->$field ;
                }
            }
        }


        foreach ($this->_fields as $field) {
            if ($field == "updated_at") {
                $this->$field = date("Y-m-d H:i:s") ;
            }

            $pdoStat->updateNewField($field, $this->$field) ;
        }

        $pdoStat->where($where) ;

        // effectue la mise à jour
        $pdoStat->update();
    }






    /************* magic function ***************/

    public function __call($method, $arguments) {
        // search a generic method
        if ($this->startsWith($method, 'findBy_')) {
            return $this->findBy($method, $arguments) ;
        } else {
            throw new Exception('Unknown method : ' . $method . ' in model');
        }
    }



    private function findBy($method, $arguments) {
        $columnName = substr($method, strlen('findBy_')) ;


        if (isset($arguments[0])) {
            return $this->database()->table($this->table_name)->where(array($columnName => $arguments[0]))->result();
        } else {
            return null ;
        }
    }




    private function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}

