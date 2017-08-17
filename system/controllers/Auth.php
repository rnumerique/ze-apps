<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends ZeCtrl
{
    public function index()
    {
        $this->load->model("Zeapps_users", "user");

        // verifie si la session est active
        if ($token = $this->session->get('token')) {
            if ($this->user->getUserByToken($token)) {
                header("location:/zeapps/app");
            } else {
                $this->loadForm();
            }
        } else {
            $this->loadForm();
        }
    }

    private function loadForm()
    {
        $data = array();
        $data["form"] = true;
        $data["error"] = false;

        if ($this->input->post('email') && $this->input->post('email') != "" && $this->input->post('password') && $this->input->post('password') != "") {
            $token = $this->user->getToken($this->input->post('email'), $this->input->post('password'));

            if ($token === false) {
                $data["error"] = true;
            } else {
                $this->session->set('token', $token);

                header("location:/zeapps/app");
                exit();
            }
        }

        $this->load->view('login', $data);
    }

    public function logout()
    {
        $this->load->model("Zeapps_token", "token");

        if ($this->session->get('token')) {
            $this->token->delete(array('token' => $this->session->get('token')));
        }

        header("location:/");
    }
}