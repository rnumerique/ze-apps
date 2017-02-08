<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends ZeCtrl
{
    public function getAll()
    {
        $this->load->library('session');
        $this->load->model("zeapps_notification", "notification");
        $this->load->model("zeapps_users", "user");
        $user = $this->user->getUserByToken($this->session->userdata('token'));

        $notification = $this->notification->get_all(array('id_user'=>$user->id));
        if($notification) {
            echo json_encode($notification);
        }
    }

    public function getAllUnread()
    {
        $this->load->library('session');
        $this->load->model("zeapps_notification", "notification");
        $this->load->model("zeapps_users", "user");
        $user = $this->user->getUserByToken($this->session->userdata('token'));

        $notification = $this->notification->get_all(array("read_state"=>0, 'id_user'=>$user->id));
        if($notification) {
            echo json_encode($notification);
        }
    }


    public function seenNotification()
    {
        $this->load->library('session');
        $this->load->model("zeapps_notification", "notification");
        $this->load->model("zeapps_users", "user");
        $user = $this->user->getUserByToken($this->session->userdata('token'));

        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);

        }

        if($data){
            foreach($data as $module){
                for($j=0; $j < sizeof($module); $j++) {
                    $this->notification->update(array("seen" => $module['notifications'][$j]["seen"]), array("id"=>$module['notifications'][$j]["id"], 'id_user'=>$user->id));
                }
            }
        }
    }


    public function readNotification($id = null)
    {
        $this->load->library('session');
        $this->load->model("zeapps_notification", "notification");
        $this->load->model("zeapps_users", "user");
        $user = $this->user->getUserByToken($this->session->userdata('token'));

        if($id){
                $this->notification->update(array("read_state"=>1), array("id"=>$id, 'id_user'=>$user->id));
        }
        echo json_encode("OK");
    }

    public function readAllNotificationFrom($module = null)
    {
        $this->load->library('session');
        $this->load->model("zeapps_notification", "notification");
        $this->load->model("zeapps_users", "user");
        $user = $this->user->getUserByToken($this->session->userdata('token'));

        if($module){
            $this->notification->update(array("read_state"=>1), array('module'=>$module, 'id_user'=>$user->id));
        }
        echo json_encode("OK");
    }

}