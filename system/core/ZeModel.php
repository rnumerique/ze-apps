<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeModel
{
    public static $_load = null ;
    protected $load = null ;
    public static $_dbConfig = null ;
    protected $dbConfig = null ;
    private $_ctrl = null;
    private $_db = null ;
    protected $_tableName = '' ;
    protected $_fields = array() ;
    protected $_primary_key = null ;
    private $safeDelete = false ;

    private $_orderBy = [] ;
    private $_limit = -1 ;
    private $_limitOffset = 0 ;

    public function __construct($dbConfig = "default")
    {
        $this->load = self::$_load ;

        if (self::$_dbConfig == null) {
            self::$_dbConfig = $dbConfig ;
        }

        $this->dbConfig = self::$_dbConfig ;

        if ($this->_tableName == '') {
            $this->_tableName = str_replace('_model', '', strtolower(get_class($this)));
        }

        // get all fields
        $this->_fields = $this->database()->table($this->_tableName)->getColumnName();


        // define all fields
        foreach ($this->_fields as $field) {
            $this->$field = null ;
        }

        $this->_primary_key = $this->database()->table($this->_tableName)->getPrimaryKey();

        // check if table is safe delete
        foreach ($this->_fields as $field) {
            if ($field == 'deleted_at') {
                $this->safeDelete = true ;
            }
        }
    }

    private function clearSql()
    {
        $this->_orderBy = [] ;
        $this->_limit = -1 ;
        $this->_limitOffset = 0 ;
    }

    public function order_by($fields, $order = 'ASC')
    {
        if (is_array($fields)) {
            reset($fields);
            if (is_int(key($fields))) { // SIMPLE ARRAY [column1, column2, ...]
                foreach ($fields as $field) {
                    $this->_orderBy[$field] = $order;
                }
            } else { // ASSOCIATIVE ARRAY [column1 => order1, column2 => order2, ...]
                foreach ($fields as $field => $order) {
                    $this->_orderBy[$field] = $order;
                }
            }
        } else { // FIELDS IS A STRING (faster way to write it if you want to pass a single value)
            $this->_orderBy[$fields] = $order;
        }

        return $this ;
    }

    public function limit($limit, $offset = 0)
    {
        $this->_limit = $limit ;
        $this->_limitOffset = $offset ;

        return $this ;
    }




    public function setDb($dbConfig)
    {
        self::$_dbConfig = $dbConfig ;
        $this->database()->setDb($dbConfig);
    }


    public function database()
    {
        // open connexion if necessary
        if ($this->_db == null) {
            $this->_db = new ZeQuery();
            $this->_db->setDb();
        }

        return $this->_db ;
    }

    public function all($where = array())
    {
        $this->database()->clearSql();

        $db = $this->database()->table($this->_tableName);

        if ($this->_orderBy != []) {
            $db->order_by($this->_orderBy);
        }

        if ($this->_limit != -1) {
            $db->limit($this->_limit, $this->_limitOffset);
        }

        if ($this->safeDelete) {
            $where["deleted_at"] = null ;
        }

        // to forget "order by" & "limit" for next query
        $this->clearSql();

        return $db->where($where)->result();
    }

    public function get($where)
    {
        $this->database()->clearSql();
        $where = $this->_formatWhere($where);
        if (count($where) >= 1) {

            if ($this->safeDelete) {
                $where["deleted_at"] = null ;
            }

            $result = $this->database()->table($this->_tableName)->where($where)->result();

            if ($result && count($result) == 1) {
                return $result[0] ;
            } else {
                return false ;
            }
        }

        return null ;
    }

    public function delete($where, $forceDelete = false)
    {
        $where = $this->_formatWhere($where);
        if (count($where) >= 1) {
            if ($forceDelete || $this->safeDelete == false) {
                $this->database()->clearSql();
                return $this->database()->table($this->_tableName)->delete($where);
            } else {
                $this->database()->clearSql();
                $data["deleted_at"] = date("Y-m-d H:i:s");
                return $this->update($data, $where);
            }
        } else {
            throw new Exception("Please pass a condition to the delete function (either value(s) 
            corresponding to the primary key, or an array)"
            );
        }
    }

    /*public function save() {
        $this->database()->clearSql();

        if ($this->_primary_key) {
            $primaryKey = $this->_primary_key ;
            if ($this->$primaryKey) {
                return $this->update(null, array($primaryKey=>$this->$primaryKey));
            } else {
                return $this->insert();
            }
        } else {
            throw new Exception('No primary key defined in table : ' . $this->_table_name);
        }
    }*/

    public function insert($objData = null)
    {
        $this->database()->clearSql();

        $pdoStat = $this->database()->table($this->_tableName);

        $fieldToUpdate = $this->_fields ;

        // copie all data to object if object
        if (is_object($objData)) {
            $fieldToUpdate = array();

            foreach ($this->_fields as $field) {
                if (isset($objData->$field)) {
                    $fieldToUpdate[] = $field;
                    $this->$field = $objData->$field;
                }
            }
            // copie all data to object if array
        } elseif (is_array($objData)) {
            $fieldToUpdate = array();

            foreach ($this->_fields as $field) {
                if (isset($objData[$field])) {
                    $fieldToUpdate[] = $field ;
                    $this->$field = $objData[$field] ;
                }
            }
        }


        foreach ($fieldToUpdate as $field) {
            $insert = true ;
            if ($field == "created_at" && $this->$field == null) {
                $insert = false ;
            } elseif ($field == "updated_at" && $this->$field == null) {
                $insert = false ;
            }
            if ($insert) {
                $pdoStat->insertNewField($field, $this->$field);
            }
        }


        foreach ($this->_fields as $field) {
            if ($field == "created_at") {
                $this->$field = date("Y-m-d H:i:s");
                $pdoStat->insertNewField($field, $this->$field);
            } elseif ($field == "updated_at") {
                $this->$field = date("Y-m-d H:i:s");
                $pdoStat->insertNewField($field, $this->$field);
            }
        }


        // insert le contenu
        return $pdoStat->create();
    }

    public function update($objData = null, $where = null)
    {
        $this->database()->clearSql();

        $pdoStat = $this->database()->table($this->_tableName);

        $fieldToUpdate = $this->_fields ;


        // copie all data to object if object
        if (is_object($objData)) {
            $fieldToUpdate = array();

            foreach ($this->_fields as $field) {
                if (isset($objData->$field)) {
                    $fieldToUpdate[] = $field;
                    $this->$field = $objData->$field;
                }
            }
            // copie all data to object if array
        } elseif (is_array($objData)) {
            $fieldToUpdate = array();

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
                $this->$field = date("Y-m-d H:i:s");
            }

            $pdoStat->updateNewField($field, $this->$field);
        }

        if ($updated_at_find == false) {
            foreach ($this->_fields as $field) {
                if ($field == "updated_at") {
                    $this->$field = date("Y-m-d H:i:s");
                    $pdoStat->updateNewField($field, $this->$field);
                }
            }
        }

        $where = $this->_formatWhere($where);

        $pdoStat->where($where);

        // effectue la mise à jour
        return $pdoStat->update();
    }






    /************* magic function ***************/

    public function __call($method, $arguments)
    {
        // search a generic method
        if ($this->startsWith($method, 'findBy_')) {
            return $this->findBy($method, $arguments);
        } elseif ($this->startsWith($method, 'findOneBy_')) {
            return $this->findOneBy($method, $arguments);
        } else {
            throw new Exception('Unknown method : ' . $method . ' in model');
        }
    }



    private function findBy($method, $arguments)
    {
        $this->database()->clearSql();

        $columnName = substr($method, strlen('findBy_'));

        if (isset($arguments[0])) {
            $db = $this->database()->table($this->_tableName);

            if ($this->_orderBy != []) {
                $db->order_by($this->_orderBy);
            }

            if ($this->_limit != -1) {
                $db->limit($this->_limit, $this->_limitOffset);
            }

            // to forget "order by" & "limit" for next query
            $this->clearSql();


            $where = array($columnName => $arguments[0]);

            if ($this->safeDelete) {
                $where["deleted_at"] = null ;
            }

            return $db->where($where)->result();
        } else {
            return null ;
        }
    }

    private function findOneBy($method, $arguments)
    {
        $this->database()->clearSql();

        $columnName = substr($method, strlen('findOneBy_'));

        if (isset($arguments[0])) {
            $where = array($columnName => $arguments[0]);

            if ($this->safeDelete) {
                $where["deleted_at"] = null ;
            }


            $result = $this->database()->table($this->_tableName)->limit(1)->where($where)->result();

            if ($result && count($result) == 1) {
                return $result[0] ;
            } else {
                return false ;
            }
        } else {
            return null ;
        }
    }




    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    private function _formatWhere($where)
    {
        if (!is_array($where) || is_int(key($where))) {
            if ($this->_primary_key) {
                return array($this->_primary_key => $where);
            } else {
                throw new Exception('No primary key defined in table : ' . $this->_tableName);
            }
        }
        return $where;
    }
}

