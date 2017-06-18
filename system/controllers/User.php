<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends ZeCtrl
{
    public function index()
    {
        $data = array();

        $this->load->view('user/index', $data);
    }


    public function modal_user()
    {
        $data = array();

        $this->load->view('user/modalUser', $data);
    }


    public function getRightList()
    {
        require_once BASEPATH . "config/right.php";


        /********** charge tous les espaces **********/
        $space = array();
        $folderSpace = FCPATH . "space/";
        // charge tous les fichiers de conf des menus
        if ($folder = opendir($folderSpace)) {
            while (false !== ($folderItem = readdir($folder))) {
                $fileSpace = $folderSpace . $folderItem;
                if (is_file($fileSpace) && $folderItem != '.' && $folderItem != '..') {
                    require_once $fileSpace;
                }
            }
        }
        /********** END : charge tous les espaces **********/


        $data = array();

        foreach ($space as $spaceItem) {
            $dataSpace = array();
            $dataSpace["info"] = $spaceItem;
            $dataSpace["section"] = array();


            $sections = array();
            foreach ($rightList as $rightItem) {
                if ($rightItem["space"] == $spaceItem["id"]) {

                    if (!in_array($rightItem["section"], $sections)) {
                        $sections[] = $rightItem["section"];
                    }
                }
            }


            foreach ($sections as $section) {
                $dataItem = array();
                $dataItem["info"] = $section;
                $dataItem["item"] = array();

                foreach ($rightList as $rightItem) {
                    if ($rightItem["space"] == $spaceItem["id"] && $section == $rightItem["section"]) {
                        $dataItem["item"][] = $rightItem;
                    }
                }

                if (count($dataItem["item"])) {
                    $dataSpace["section"][] = $dataItem;
                }
            }

            if (count($dataSpace["section"]) > 0) {
                $data[] = $dataSpace;
            }
        }


        echo json_encode($data);
    }


    public function getAll()
    {
        $this->load->model("Zeapps_users", "users");
        $users = $this->users->all();
        echo json_encode($users);
    }

    public function form()
    {
        $data = array();

        $this->load->view('user/form', $data);
    }


    public function get($id)
    {
        $this->load->model("Zeapps_users", "users");
        echo json_encode($this->users->get($id));
    }


    public function save()
    {
        $this->load->model("Zeapps_users", "users");

        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0
            && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $this->users->update($data, $data["id"]);
        } else {
            $this->users->insert($data);
        }

        echo json_encode("OK");
    }


    public function delete($id)
    {
        $this->load->model("Zeapps_users", "users");
        $this->users->delete($id);

        echo json_encode("OK");
    }


    public function getCurrentUser()
    {
        $this->load->model("Zeapps_users", "user");


        // verifie si la session est active
        if ($this->session->get('token')) {
            $user = $this->user->getUserByToken($this->session->get('token'));
            if ($user && count($user) == 1) {
                $data = [];
                $data["id"] = $user[0]->id;
                $data["firstname"] = $user[0]->firstname;
                $data["lastname"] = $user[0]->lastname;
                $data["email"] = $user[0]->email;
                $data["lang"] = $user[0]->lang;

                echo json_encode($data);
            }
        }
    }
}
