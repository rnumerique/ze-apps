<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(BASEPATH . 'controllers/User.php');

class Profile extends User
{
    public function view()
    {
        $data = array();

        $this->load->view('profile/view', $data);
    }

    public function form()
    {
        $data = array();

        $this->load->view('profile/form', $data);
    }

    public function notifications()
    {
        $data = array();

        $this->load->view('profile/notifications', $data);
    }


    public function update_user()
    {

        $this->load->library('session');
        $this->load->model("Zeapps_users", "user");

        // constitution du tableau
        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }


        $user = $this->user->getUserByToken($this->session->userdata('token'));

        $data['id'] = $user->id;

        $this->user->update($data, $data["id"]);
    }


}
