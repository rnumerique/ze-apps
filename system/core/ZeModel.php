<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeModel {
    public static $_load = null ;
    protected $load = null ;
    public static $_dbConfig = null ;
    protected $dbConfig = null ;
    private $_ctrl = null;
    private $_db = null ;
    protected $_table_name = '' ;
    protected $_fields = array() ;
    protected $_primary_key = null ;
    private $safeDelete = false ;

    private $_order_by = "" ;
    private $_limit = -1 ;
    private $_limit_offset = 0 ;

    public function __construct($dbConfig = "default") {
        $this->load = self::$_load ;

        if (self::$_dbConfig == null) {
            self::$_dbConfig = $dbConfig ;
        }

        $this->dbConfig = self::$_dbConfig ;



        // get all fields
        $this->_fields = $this->database()->table($this->_table_name)->getColumnName() ;


        // define all fields
        foreach ($this->_fields as $field) {
            $this->$field = null ;
        }

        $this->_primary_key = $this->database()->table($this->_table_name)->getPrimaryKey() ;

        if($this->_table_name == '') {
            $this->_table_name = str_replace('_model', '', strtolower(get_class($this)));
        }


        // check if table is safe delete
        foreach ($this->_fields as $field) {
            if ($field == 'deleted_at') {
                $this->safeDelete = true ;
            }
        }
    }

    private function clearSql() {
        $this->_order_by = "" ;
        $this->_limit = -1 ;
        $this->_limit_offset = 0 ;
    }

    public function order_by($argString) {
        $this->_order_by = $argString ;

        return $this ;
    }

    public function limit($limit, $offset = 0) {
        $this->_limit = $limit ;
        $this->_limit_offset = $offset ;

        return $this ;
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

    public function all($where = array()) {
        $this->database()->clearSql() ;

        $db = $this->database()->table($this->_table_name) ;

        if ($this->_order_by != "") {
            $db->order_by($this->_order_by) ;
        }

        if ($this->_limit != -1) {
            $db->limit($this->_limit, $this->_limit_offset) ;
        }

        // to forget "order by" & "limit" for next query
        $this->clearSql() ;

        return $db->where($where)->result() ;
    }

    public function get($id) {
        $this->database()->clearSql() ;
        if ($this->_primary_key) {
            $where = array() ;
            $where[$this->_primary_key] = $id ;

            $result = $this->database()->table($this->_table_name)->where($where)->result() ;

            if ($result && count($result) == 1) {
                foreach ($this->_fields as $field) {
                    if (isset($result[0]->$field)) {
                        $this->$field = $result[0]->$field ;
                    } else {
                        $this->$field = null ;
                    }
                }

                return $this ;
            } else {
                return false ;
            }
        }

        return null ;
    }

    public function delete($arrData, $forceDelete = false) {
        if (count($arrData) >= 1) {
            if ($forceDelete || $this->safeDelete == false) {
                $this->database()->clearSql();
                return $this->database()->table($this->_table_name)->delete($arrData);
            } else {
                $this->database()->clearSql();
                $data["deleted_at"] = date("Y-m-d H:i:s");
                return $this->update($data, $arrData);
            }
        } else {
            throw new Exception("Please fill array() with your condition to delete");
        }
    }

    public function save() {
        $this->database()->clearSql() ;

        if ($this->_primary_key) {
            $primaryKey = $this->_primary_key ;
            if ($this->$primaryKey) {
                return $this->update(null, array($primaryKey=>$this->$primaryKey)) ;
            } else {
                return $this->insert() ;
            }
        } else {
            throw new Exception('No primary is define in table : ' . $this->_table_name);
        }
    }

    public function insert() {
        $this->database()->clearSql() ;

        $pdoStat = $this->database()->table($this->_table_name) ;

        foreach ($this->_fields as $field) {

            if ($field == "created_at") {
                $this->$field = date("Y-m-d H:i:s") ;
            } elseif ($field == "updated_at") {
                $this->$field = date("Y-m-d H:i:s") ;
            }

            $pdoStat->insertNewField($field, $this->$field) ;
        }

        // insert le contenu
        return $pdoStat->create();
    }

    public function update($objData = null, $where) {
        $this->database()->clearSql() ;

        $pdoStat = $this->database()->table($this->_table_name) ;

        $fieldToUpdate = $this->_fields ;


        // copie all data to object if object
        if (is_object($objData)) {
            $fieldToUpdate = array() ;

            foreach ($this->_fields as $field) {
                if (isset($objData->$field)) {
                    $fieldToUpdate[] = $field ;
                    $this->$field = $objData->$field ;
                }
            }
        }
        // copie all data to object if array
        else if (is_array($objData)) {
            $fieldToUpdate = array() ;

            foreach ($this->_fields as $field) {
                if (isset($objData[$field])) {
                    $fieldToUpdate[] = $field ;
                    $this->$field = $objData[$field] ;
                }
            }
        }


        // check if find update_at field
        $updated_at_find = false ;

        foreach ($fieldToUpdate as $field) {
            if ($field == "updated_at") {
                $updated_at_find = true ;
                $this->$field = date("Y-m-d H:i:s") ;
            }

            $pdoStat->updateNewField($field, $this->$field) ;
        }

        if ($updated_at_find == false) {
            foreach ($this->_fields as $field) {
                if ($field == "updated_at") {
                    $this->$field = date("Y-m-d H:i:s") ;
                    $pdoStat->updateNewField($field, $this->$field) ;
                }
            }
        }


        $pdoStat->where($where) ;

        // effectue la mise à jour
        return $pdoStat->update();
    }






    /************* magic function ***************/

    public function __call($method, $arguments) {
        // search a generic method
        if ($this->startsWith($method, 'findBy_')) {
            return $this->findBy($method, $arguments) ;
        } elseif ($this->startsWith($method, 'findOneBy_')) {
            return $this->findOneBy($method, $arguments) ;
        } else {
            throw new Exception('Unknown method : ' . $method . ' in model');
        }
    }



    private function findBy($method, $arguments) {
        $this->database()->clearSql() ;

        $columnName = substr($method, strlen('findBy_')) ;

        if (isset($arguments[0])) {
            $db = $this->database()->table($this->_table_name) ;

            if ($this->_order_by != "") {
                $db->order_by($this->_order_by) ;
            }

            if ($this->_limit != -1) {
                $db->limit($this->_limit, $this->_limit_offset) ;
            }

            // to forget "order by" & "limit" for next query
            $this->clearSql() ;

            return $db->where(array($columnName => $arguments[0]))->result() ;
        } else {
            return null ;
        }
    }

    private function findOneBy($method, $arguments) {
        $this->database()->clearSql() ;

        $columnName = substr($method, strlen('findOneBy_')) ;

        if (isset($arguments[0])) {
            $result = $this->database()->table($this->_table_name)->limit(1)->where(array($columnName => $arguments[0]))->result() ;

            if ($result && count($result) == 1) {
                return $result[0] ;
            } else {
                return false ;
            }
        } else {
            return null ;
        }
    }




    private function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}

