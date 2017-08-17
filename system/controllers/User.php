<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends ZeCtrl
{
    public function view()
    {
        $this->load->view('user/view');
    }

    public function modal_user()
    {
        $this->load->view('user/modalUser');
    }

    public function form()
    {
        $this->load->view('user/form');
    }

    public function get($id)
    {
        $this->load->model("Zeapps_users", "users");
        $this->load->model("Zeapps_user_groups", "user_groups");
        $this->load->model("Zeapps_groups", "groups");
        $this->load->model("Zeapps_modules", "modules");
        $this->load->model("Zeapps_module_rights", "module_rights");

        if($user = $this->users->get($id)){
            $user->groups = [];
            if($user_groups = $this->user_groups->all(array('id_user' => $user->id))){
                foreach($user_groups as $user_group){
                    $user->groups[$user_group->id_group] = true;
                }
            }
        }

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
            'user' => $user,
            'groups' => $groups,
            'modules' => $modules
        ));
    }

    public function get_context()
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

    public function all()
    {
        $this->load->model("Zeapps_users", "users");

        $users = $this->users->all();

        echo json_encode($users);
    }

    public function modal($limit = 15, $offset = 0)
    {
        $this->load->model("Zeapps_users", "users");

        $total = $this->users->count();

        if(!$users = $this->users->limit($limit, $offset)->all()){
            $users = [];
        }

        echo json_encode(array("data" => $users, "total" => $total));
    }

    public function save()
    {
        $this->load->model("Zeapps_users", "users");
        $this->load->model("Zeapps_user_groups", "user_groups");

        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0
            && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $this->users->update($data, $data["id"]);
            $id = $data['id'];

            if($data['groups'] && is_array($data['groups'])){
                foreach($data['groups'] as $id_group => $value){
                    if($value){
                        if(!$this->user_groups->get(array('id_user' => $id,'id_group' => $id_group))) {
                            $this->user_groups->insert(array(
                                'id_user' => $id,
                                'id_group' => $id_group
                            ));
                        }
                    }
                    else{
                        $this->user_groups->delete(array(
                            'id_user' => $id,
                            'id_group' => $id_group
                        ));
                    }
                }
            }
        } else {
            $id = $this->users->insert($data);

            if($data['groups'] && is_array($data['groups'])){
                foreach($data['groups'] as $id_group => $value){
                    if($value){
                        if(!$this->user_groups->get(array('id_user' => $id,'id_group' => $id_group))) {
                            $this->user_groups->insert(array(
                                'id_user' => $id,
                                'id_group' => $id_group
                            ));
                        }
                    }
                }
            }
        }

        echo $id;
    }

    public function delete($id)
    {
        $this->load->model("Zeapps_users", "users");

        echo $this->users->delete($id);
    }

    public function getCurrentUser()
    {
        $this->load->model("Zeapps_users", "user");
        //$this->load->model("Zeapps_user_rights", "rights");


        // verifie si la session est active
        if ($this->session->get('token')) {
            $user = $this->user->getUserByToken($this->session->get('token'));
            if ($user && count($user) == 1) {
                $data = [];
                $data["id"] = $user->id;
                $data["firstname"] = $user->firstname;
                $data["lastname"] = $user->lastname;
                $data["email"] = $user->email;
                $data["lang"] = $user->lang;

                //$data["rights"] = $this->rights->getRightsOf($user->id);

                echo json_encode($data);
            }
        }
    }
}
