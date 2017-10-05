<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends ZeCtrl
{

    public function index()
    {
        $this->load->view('config/index');
    }

    public function get($id)
    {
        $this->load->model('Zeapps_configs', 'configs');

        $config = $this->configs->get(array('id' => $id));

        echo json_encode($config);
    }

    public function save()
    {
        $this->load->model('Zeapps_configs', 'configs');

        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if ($data && is_array($data)) {
            if (isset($data[0]) && is_array($data[0])) { // Multidimensionnal array, we are saving multiple config settings at once
                for ($i = 0; $i < sizeof($data); $i++) {
                    if ($this->configs->get(array('id' => $data[$i]['id']))) {
                        $res = $this->configs->update($data[$i], array('id' => $data[$i]['id']));
                    } else {
                        $res = $this->configs->insert($data[$i]);
                    }
                }
            } else {
                if ($this->configs->get($data['id'])) {
                    $res = $this->configs->update($data, array('id' => $data['id']));
                } else {
                    $res = $this->configs->insert($data);
                }
            }
        }

        echo json_encode(!!$res);
    }

    public function emptyCache()
    {

        clearCache();

        echo json_encode('OK');

    }
}
