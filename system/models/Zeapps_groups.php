<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zeapps_groups extends ZeModel
{
    public function searchFor($terms = array()){
        $query = "SELECT * FROM zeapps_groups WHERE (1 ";

        foreach($terms as $term){
            $query .= "AND (label LIKE '%".$term."%') ";
        }

        $query .= ") AND deleted_at IS NULL LIMIT 10";

        return $this->database()->customQuery($query)->result();
    }
}