<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeQuery
{
    private $_db = null ;
    private $_dbPDO = null ;

    // for QueryBuilder
    private $_select = "*" ;
    private $_table = "" ;
    private $_join = "" ;
    private $_where = "" ;
    private $_group_by = "" ;
    private $_order_by = [] ;
    private $_limit = "" ;
    private $_query = "" ;
    private $_valueQuery = array() ;
    private $_insertFieldName = "" ;
    private $_insertValueField = "" ;
    private $_updateValueField = "" ;

    private $_fieldToInsert = array() ; // to controle the field

    public function __construct()
    {
    }


    public function setDb($dbConfig = "default") {
        $this->_db = ZeDatabase::getInstance() ;
        $this->_dbPDO = $this->_db->open($dbConfig) ;
    }

    public function clearSql() {
        $this->_select = "*" ;
        $this->_table = "" ;
        $this->_join = "" ;
        $this->_where = "" ;
        $this->_group_by = "" ;
        $this->_order_by = [] ;
        $this->_limit = "" ;
        $this->_query = "" ;
        $this->_insertFieldName = "" ;
        $this->_insertValueField = "" ;
        $this->_updateValueField = "" ;
        $this->_valueQuery = array() ;
        $this->_fieldToInsert = array() ;
    }

    public function insertNewField($key, $value) {
        if (!in_array($key, $this->_fieldToInsert)) {
            $this->_fieldToInsert[] = $key ;

            if ($this->_insertFieldName != "") {
                $this->_insertFieldName .= ", ";
                $this->_insertValueField .= ", ";
            }

            $keyName = ":" . $key . count($this->_valueQuery);
            $this->_valueQuery[$keyName] = $value;

            $this->_insertFieldName .= $key;
            $this->_insertValueField .= $keyName;
        }
    }

    public function updateNewField($key, $value) {
        if ($this->_updateValueField != "") {
            $this->_updateValueField .= ", " ;
        }

        $keyName = ":" . $key . count($this->_valueQuery) ;
        $this->_valueQuery[$keyName] = $value ;

        $this->_updateValueField .= $key . " = " . $keyName ;
    }



    public function getColumnName() {
        $q = $this->_dbPDO->prepare("DESCRIBE " . $this->_table);
        $q->execute();
        return $q->fetchAll(PDO::FETCH_COLUMN);
    }


    public function getPrimaryKey() {
        $q = $this->_dbPDO->prepare("show columns from " . $this->_table . " WHERE `Key` = \"PRI\"");
        $q->execute();

        $rs = $q->fetchAll(PDO::FETCH_CLASS) ;

        if (isset($rs[0]->Field)) {
            return $rs[0]->Field ;
        } else {
            return null ;
        }
    }




    public function select($argString) {
        $this->_select = $argString ;

        return $this ;
    }

    public function table($argString) {
        $this->_table = $argString ;

        return $this ;
    }

    public function join($table, $argString, $typeJoin = 'INNER') {
        $this->_join .= $typeJoin . " JOIN " . $table . " ON " . $argString . " " ;

        return $this ;
    }

    public function where($arrData) {
        foreach ($arrData as $key => $value) {
            if ($this->_where != '') {
                $this->_where .= " AND ";
            }
            $keyName = ":" . $key . count($this->_valueQuery);
            $keyName = str_replace(" ", "_", $keyName);
            $keyName = str_replace(">", "_", $keyName);
            $keyName = str_replace("<", "_", $keyName);
            $keyName = str_replace(".", "_", $keyName);


            if (!is_array($value) && $value != null) {
                $this->_valueQuery[$keyName] = $value;
            }


            if ($value == null) {
                $this->_where .= $key . " IS NULL ";
            } elseif (is_array($value)) {
                $stringValue = "";
                foreach ($value as $value_content) {
                    if ($stringValue != '') {
                        $stringValue .= ", ";
                    }
                    $stringValue .= "'" . $value_content . "'";
                }
                $this->_where .= $key . " IN (" . $stringValue . ") ";
            } elseif (strpos($key, "<") || strpos($key, ">")) {
                $this->_where .= $key . " " . $keyName;
            } else {
                $this->_where .= $key . " = " . $keyName;
            }
        }

        return $this ;
    }

    public function group_by($argString) {
        $this->_group_by = $argString ;

        return $this ;
    }

    public function order_by($fields, $order = 'ASC') {
        if(is_array($fields)){
            reset($fields);
            if(is_int(key($fields))){ // SIMPLE ARRAY [column1, column2, ...]
                foreach ($fields as $field) {
                    $this->_order_by[$field] = $order;
                }
            }
            else { // ASSOCIATIVE ARRAY [column1 => order1, column2 => order2, ...]
                foreach ($fields as $field => $order) {
                    $this->_order_by[$field] = $order;
                }
            }
        }
        else { // FIELDS IS A STRING (faster way to write it if you want to pass a single value)
            $this->_order_by[$fields] = $order;
        }

        return $this ;
    }

    public function limit($limit, $offset = 0) {
        $this->_limit = " LIMIT " . $limit . " OFFSET " . $offset ;

        return $this ;
    }


    public function query($argString) {
        $this->_query = $argString ;

        return $this ;
    }



    public function result() {
        if ($this->_query == '') {
            $this->_createQuery() ;
        }

        $sth = $this->_dbPDO->prepare($this->_query);
        $this->_cast($sth);

        // clean SQL Query
        $this->clearSql();

        // return fetched objects
        return $sth->fetchAll(PDO::FETCH_CLASS);
    }

    public function create() {
        $this->_createInsertQuery() ;
        $sth = $this->_dbPDO->prepare($this->_query);

        $this->_cast($sth);

        $last_id = $this->_dbPDO->lastInsertId();

        if(is_numeric($last_id))
            $last_id = intval($last_id);

        return $last_id ?:false;
    }

    public function update() {
        $this->_createUpdateQuery() ;
        $sth = $this->_dbPDO->prepare($this->_query);

        return $this->_cast($sth) ?:false;
    }

    public function delete($arrData) {
        $this->where($arrData) ;
        $this->_deleteQuery() ;
        $sth = $this->_dbPDO->prepare($this->_query);
        return $this->_cast($sth) ?:false;
    }



    private function _cast($sth){
        if($this->_db->debug) {
            try {
                return $sth->execute($this->_valueQuery);
            } catch (PDOException $err) {
                // Catch Expcetions from the above code for our Exception Handling
                $trace = '<table border="0">';
                foreach ($err->getTrace() as $a => $b) {
                    foreach ($b as $c => $d) {
                        if ($c == 'args') {
                            foreach ($d as $e => $f) {
                                $trace .= '<tr><td><b>' . strval($a) . '#</b></td><td align="right"><u>args:</u></td> <td><u>' . $e . '</u>:</td><td><i>' . $f . '</i></td></tr>';
                            }
                        } else {
                            $trace .= '<tr><td><b>' . strval($a) . '#</b></td><td align="right"><u>' . $c . '</u>:</td><td></td><td><i>' . $d . '</i></td>';
                        }
                    }
                }
                $trace .= '</table>';
                echo '<br /><br /><br /><fieldset style="width: 66%; border: 4px solid white; background: black;"><legend><b>[</b>PHP PDO Error ' . strval($err->getCode()) . '<b>]</b></legend> <table border="0"><tr><td align="right"><b><u>Message:</u></b></td><td><i>' . $err->getMessage() . '</i></td></tr><tr><td align="right"><b><u>Code:</u></b></td><td><i>' . strval($err->getCode()) . '</i></td></tr><tr><td align="right"><b><u>File:</u></b></td><td><i>' . $err->getFile() . '</i></td></tr><tr><td align="right"><b><u>Line:</u></b></td><td><i>' . strval($err->getLine()) . '</i></td></tr><tr><td align="right"><b><u>Trace:</u></b></td><td><br /><br />' . $trace . '</td></tr></table></fieldset>';
                return false;
            }
        }
        else{
            return $sth->execute($this->_valueQuery);
        }
    }



    private function _createQuery() {
        $this->_query = "SELECT " . $this->_select . " FROM " . $this->_table . " "  ;

        if ($this->_join != '') {
            $this->_query .= $this->_join . " " ;
        }

        if ($this->_where != '') {
            $this->_query .= "WHERE " . $this->_where . " " ;
        }

        if ($this->_group_by != '') {
            $this->_query .= "GROUP BY " . $this->_group_by . " " ;
        }

        if ($this->_order_by != []) {
            $this->_query .= 'ORDER BY ';
            foreach($this->_order_by as $column => $order) {
                $this->_query .= $column . " " . $order . ", ";
            }
            $this->_query = rtrim($this->_query, ', ') . ' ';
        }
    }



    private function _createInsertQuery() {
        $this->_query = "INSERT INTO " . $this->_table . " "  ;

        $this->_query .= " (" . $this->_insertFieldName . ") " ;
        $this->_query .= " VALUES (" . $this->_insertValueField . ") " ;
    }

    private function _createUpdateQuery() {
        $this->_query = "UPDATE " . $this->_table . " "  ;

        $this->_query .= "SET " . $this->_updateValueField . " " ;

        if ($this->_where != '') {
            $this->_query .= "WHERE " . $this->_where . " " ;
        }
    }

    private function _deleteQuery() {
        $this->_query = "DELETE FROM " . $this->_table . " "  ;

        if ($this->_where != '') {
            $this->_query .= "WHERE " . $this->_where . " " ;
        }
    }
}

