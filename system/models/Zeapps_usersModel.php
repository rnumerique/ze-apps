<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserTempActiveRecord extends ZeModel {
  static $table_name = 'zeapps_users';
}

class Zeapps_usersModel extends ZeModel {
    private $typeHash = 'sha256';
    static $table_name = 'zeapps_users';




    public function getUserByToken($token_user) {
        if (gettype($token_user) == 'string') {
            self::$load->model("zeapps_tokenModel", "token");

            // supprime tous les token qui sont dépassés
            $tokens = self::$load->ctrl->token::all(array('conditions' => "date_expire < '" . date("Y-m-d H:i:s") . "'")) ;
            if (is_array($tokens) && count($tokens) > 0) {
                $ids = array() ;
                foreach ($tokens as $token) {
                    $ids[] = $token->id;
                }

                if (count($ids) > 0) {
                    self::$load->ctrl->token->delete(array('id' => $ids));
                }
            }

            // verifie le token
            $token = self::$load->ctrl->token::find_by_token($token_user) ;

            if ($token) {
                return UserTempActiveRecord::find_by_id($token->id_user) ;
                //return self::find_by_id($token->id_user) ;
            } else {
                return false ;
            }
        } else {
            return false ;
        }
    }





    public function getToken($email, $password) {
        self::$load->model("zeapps_tokenModel", "token");



        $users = self::all(array('conditions' => array('email = ? AND password = ?', $email, hash($this->typeHash, $password))));
        if ($users && count($users) == 1) {

            $token = "" ;
            while ($token == "") {
                $tokenGenerated = hash($this->typeHash, uniqid()) ;

                $tokens = self::$load->ctrl->token::all(array('conditions' => array('token = ?', $tokenGenerated))) ;

                if ($tokens && count($tokens) > 0) {
                    $token = "" ;
                } else {
                    //var_dump($users[0]);
                    //echo "\n\n\n\n\n\n\n" ;

                    $token = new self::$load->ctrl->token();
                    $token->id_user = $users[0]->id ;
                    $token->token = $tokenGenerated ;
                    $token->date_expire = date("Y-m-d H:i:s", time() + 20 * 60) ;
                    $token->save() ;
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
