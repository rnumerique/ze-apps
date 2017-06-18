<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zeapps_users extends ZeModel {
    private $typeHash = 'sha256';





    public function getUserByToken($token_user) {
        if (gettype($token_user) == 'string') {
            $this->_pLoad->model("Zeapps_token", "token");

            // supprime tous les token qui sont dépassés
            $where = array("date_expire <"=>gmdate("Y-m-d H:i:s")) ;
            $tokens = $this->_pLoad->ctrl->token->all($where) ;


            if (is_array($tokens) && count($tokens) > 0) {
                $ids = array() ;
                foreach ($tokens as $token) {
                    $ids[] = $token->id;
                }

                if (count($ids) > 0) {
                    $this->_pLoad->ctrl->token->delete(array('id' => $ids));
                }
            }

            // verifie le token
            $token = $this->_pLoad->ctrl->token->findBy_token($token_user) ;

            if ($token && isset($token[0])) {
                return $this->findBy_id($token[0]->id_user) ;
            } else {
                return false ;
            }
        } else {
            return false ;
        }
    }





    public function getToken($email, $password) {
        global $globalConfig ;

        $session_lifetime = 20 ;
        if (isset($globalConfig["session_lifetime"]) && is_numeric($globalConfig["session_lifetime"])) {
            $session_lifetime = $globalConfig["session_lifetime"] ;
        }




        $this->_pLoad->model("Zeapps_token", "token");


        $where = array() ;
        $where["email"] = $email ;
        $where["password"] = hash($this->typeHash, $password) ;
        $users = $this->all($where);
        if ($users && count($users) == 1) {

            $token = "" ;
            while ($token == "") {
                $tokenGenerated = hash($this->typeHash, uniqid()) ;

                $where = array() ;
                $where["token"] = $tokenGenerated ;
                $tokens = $this->_pLoad->ctrl->token->all($where) ;

                if ($tokens && count($tokens) > 0) {
                    $token = "" ;
                } else {
                    $token = new $this->_pLoad->ctrl->token();
                    $token->id_user = $users[0]->id ;
                    $token->token = $tokenGenerated ;
                    $token->date_expire = gmdate("Y-m-d H:i:s", time() + $session_lifetime * 60) ;
                    $token->insert($token) ;
                }
            }

            return $tokenGenerated ;

        } else {
            return false ;
        }
    }
}






/*class Zeapps_users extends MY_Model
{


public function insert($data = NULL)
{

if (isset($data["password"]) && $data["password"] != "") {
$data["password"] = hash($this->typeHash, $data["password"]);
}

return parent::insert($data);
}

public function update($data = NULL, $column_name_where = NULL, $escape = TRUE)
{
if (isset($data["password"]) && $data["password"] != "") {
$data["password"] = hash($this->typeHash, $data["password"]) ;
}

return parent::update($data, $column_name_where, $escape);
}

public function get($id = NULL) {
return $this->getCleanDataUser(parent::get($id)) ;
}

public function getToken($email, $password) {
$this->load->model("zeapps_token", "token");


$where = array() ;
$where["email"] = $email ;
$where["password"] = hash($this->typeHash, $password) ;


$users = $this->get_all($where) ;
if ($users && count($users) == 1) {

$token = "" ;
while ($token == "") {
$token = hash($this->typeHash, uniqid()) ;

$tokens = $this->token->get_all(array("token"=>$token)) ;

if ($tokens && count($tokens) > 0) {
$token = "" ;
} else {
$data = array() ;
$data["id_user"] = $users[0]->id ;
$data["token"] = $token ;
$data["date_expire"] = date("Y-m-d H:i:s", time() + 20 * 60) ;
$this->token->insert($data);
}
}

return $token ;

} else {
return false ;
}
}

public function getUserByToken($token_user) {
$this->load->model("zeapps_token", "token");
$this->load->model("zeapps_users", "user");

// supprime tous les token qui sont dépassés
$tokens = $this->token->get_all("date_expire < '" . date("Y-m-d H:i:s") . "'") ;
if (is_array($tokens) && count($tokens) > 0) {
$ids = array() ;
foreach ($tokens as $token) {
$ids[] = $token->id;
}
$this->token->delete($ids);
}


// verifie le token
$token = $this->token->get("token = " . $token_user) ;

if ($token) {
return $this->user->get($token->id_user) ;
} else {
return false ;
}
}

public function getCleanDataUser($data) {
if (isset($data->password)) {
unset($data->password);
}
return $data ;
}
}
*/
