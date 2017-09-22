<?php

class Zeapps_country extends ZeModel
{
    public function get($where = array())
    {
        return $this->database()->select('*')
            ->join(
                'zeapps_country_lang',
                'zeapps_country.id = zeapps_country_lang.id_country',
                'left'
            )
            ->where($where)
            ->table('zeapps_country')
            ->result();
    }

    public function all($where = array(), $limit = 2147483647, $offset = 0)
    {
        return $this->database()->select('*')
            ->limit($limit, $offset)
            ->join(
                'zeapps_country_lang',
                'zeapps_country.id = zeapps_country_lang.id_country',
                'left'
            )
            ->where($where)
            ->order_by('zeapps_country_lang.name', 'ASC')
            ->table('zeapps_country')
            ->result();
    }
}