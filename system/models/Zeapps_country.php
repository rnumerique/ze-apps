<?php
class Zeapps_country extends ZeModel {
    public function all($where = array()){
        return $this->database()->select('*')
                    ->join('zeapps_country_lang', 'zeapps_country.id = zeapps_country_lang.id_country', 'left')
                    ->order_by('zeapps_country_lang.name', 'ASC')
                    ->table('zeapps_country')
                    ->result();
    }
}