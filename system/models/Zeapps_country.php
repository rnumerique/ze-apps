<?php

class Zeapps_country extends ZeModel
{
    public function all($where = array(), $limit = 15, $offset = 0)
    {
        return $this->database()->select('*')
            ->limit($limit, $offset)
            ->join(
                'zeapps_country_lang',
                'zeapps_country.id = zeapps_country_lang.id_country',
                'left'
            )
            ->order_by('zeapps_country_lang.name', 'ASC')
            ->table('zeapps_country')
            ->result();
    }
}