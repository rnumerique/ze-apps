<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends ZeCtrl
{
    public function index()
    {
        $data = array();

        $this->load->view('group/index', $data);
    }


    public function getAll()
    {
        $this->load->model("Zeapps_user_groups", "groups");
        $groups = $this->groups->all();
        echo json_encode($groups);
    }

    public function form()
    {
        $data = array();

        $this->load->view('group/form', $data);
    }


    public function get($id)
    {
        $this->load->model("Zeapps_user_groups", "groups");
        echo json_encode($this->groups->get($id));
    }


    public function save()
    {
        $this->load->model("Zeapps_user_groups", "groups");

        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $this->groups->update($data, $data["id"]);
        } else {
            $this->groups->insert($data);
        }

        echo json_encode("OK");
    }


    public function delete($id)
    {
        $this->load->model("Zeapps_user_groups", "groups");
        $this->groups->delete($id);

        echo json_encode("OK");
    }


}
