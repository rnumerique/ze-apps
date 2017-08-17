<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zeapps_user_groups extends ZeModel
{
    public function all($where = array()){
        $where['zeapps_user_groups.deleted_at'] = null;

        return $this->database()->select('*')
                ->join('zeapps_groups', 'zeapps_groups.id = zeapps_user_groups.id_group', 'LEFT')
                ->where($where)
                ->where_not(array('zeapps_user_groups.id' => null))
                ->group_by('zeapps_user_groups.id')
                ->table('zeapps_user_groups')
                ->result();
    }
}