<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends ZeCtrl
{
    public function getAll()
    {
        $this->load->model("Zeapps_notifications", "notifications");
        $this->load->model("Zeapps_users", "user");

        if ($user = $this->user->getUserByToken($this->session->get('token'))) {
            if ($notifications = $this->notifications->all(array('id_user' => $user->id))) {
                echo json_encode($notifications);
            }
        }
    }

    public function getAllUnread()
    {
        $this->load->model("Zeapps_notifications", "notifications");
        $this->load->model("Zeapps_users", "user");

        if ($user = $this->user->getUserByToken($this->session->get('token'))) {
            if ($notifications = $this->notifications->all(array("read_state" => 0, 'id_user' => $user->id))) {
                echo json_encode($notifications);
            }
        }
    }


    public function seenNotification()
    {
        $this->load->model("Zeapps_notifications", "notifications");
        $this->load->model("Zeapps_users", "user");

        $data = array();

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);

        }

        if ($data) {
            foreach ($data as $module) {
                for ($j = 0; $j < sizeof($module['notifications']); $j++) {
                    $ret = $this->notifications->update(array("seen" => $module['notifications'][$j]["seen"]), $module['notifications'][$j]["id"]);
                }
            }
        }
    }


    public function readNotification($id = null)
    {
        $this->load->model("Zeapps_notifications", "notifications");
        $this->load->model("Zeapps_users", "user");

        if ($user = $this->user->getUserByToken($this->session->get('token'))) {
            if ($id) {
                $this->notifications->update(array("read_state" => 1), array("id" => $id, 'id_user' => $user->id));
            }
        }
        echo json_encode("OK");
    }

    public function readAllNotificationFrom($module = null)
    {
        $this->load->model("Zeapps_notifications", "notifications");
        $this->load->model("Zeapps_users", "user");

        if ($user = $this->user->getUserByToken($this->session->get('token'))) {
            if ($module) {
                $this->notifications->update(array("read_state" => 1), array('module' => $module, 'id_user' => $user->id));
            }
        }
        echo json_encode("OK");
    }

}