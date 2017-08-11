<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends ZeCtrl{

    public function view()
    {
        $this->load->view('group/view');
    }

    public function modal()
    {
        $this->load->view('group/modal');
    }




    public function get($id)
    {
        $this->load->model("Zeapps_groups", "groups");
        echo json_encode($this->groups->get($id));
    }

    public function all()
    {
        $this->load->model("Zeapps_groups", "groups");
        $this->load->model("Zeapps_modules", "modules");
        $this->load->model("Zeapps_module_rights", "module_rights");

        if(!$groups = $this->groups->all()){
            $groups = [];
        }

        if($modules = $this->modules->all(array('active' => 1))) {
            foreach($modules as $module){
                if($right = $this->module_rights->get(array('id_module' => $module->id))) {
                    $module->rights = json_decode($right->rights, true);
                }
                else {
                    $module->rights = false;
                }
            }
        }
        else{
            $modules = [];
        }

        echo json_encode(array(
            'groups' => $groups,
            'modules' => $modules
        ));
    }

    public function save()
    {
        $this->load->model("Zeapps_groups", "groups");

        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $this->groups->update($data, $data["id"]);
            $id = $data['id'];
        } else {
            $id = $this->groups->insert($data);
        }

        echo $id;
    }

    public function delete($id)
    {
        $this->load->model("Zeapps_groups", "groups");
        $this->groups->delete($id);

        echo json_encode("OK");
    }

}
