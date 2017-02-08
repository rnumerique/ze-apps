<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends ZeCtrl
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function index()
    {
        $this->load->view('config/index');
    }

    public function get($id){
        $this->load->model('zeapps_configs', 'configs');

        $config = $this->configs->get(array('id'=>$id));

        echo json_encode($config);
    }

    public function save(){
        $this->load->model('zeapps_configs', 'configs');

        // constitution du tableau
        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if($data && is_array($data)){
            if(isset($data[0]) && is_array($data[0])){ // Multidimensionnal array, we are saving multiple config settings at once
                for($i=0;$i<sizeof($data);$i++){
                    if ($this->configs->get(array('id'=>$data[$i]['id']))) {
                        $this->configs->update($data[$i], array('id' => $data[$i]['id']));
                    } else {
                        $this->configs->insert($data[$i]);
                    }
                }
            }
            else {
                if ($this->configs->get(array('id'=>$data['id']))) {
                    $this->configs->update($data, array('id' => $data['id']));
                } else {
                    $this->configs->insert($data);
                }
            }
        }

        echo json_encode('OK');
    }

    public function emptyCache(){

        clearCache();

        echo json_encode('OK');

    }
}
