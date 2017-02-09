<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modules extends ZeCtrl
{
    public function index()
    {
        $data = array() ;

        $this->load->view('modules/index', $data);
    }

    public function getAll() {
        $this->load->model("Zeapps_modules", "modules");
        $modules = $this->modules->all();
        echo json_encode($modules);
    }

    public function toInstall(){
        $this->load->model("Zeapps_modules", "modules");

        $toInstall = [];
        $toUpdate = [];

        $folderInstall = FCPATH . "install/" ;
        if($folder = opendir($folderInstall)) {
            while(false !== ($folderItem = readdir($folder)))
            {
                $folderModule = $folderInstall . $folderItem ;
                if(is_dir($folderModule) && $folderItem != '.' && $folderItem != '..') {

                    $configFile = $folderModule . "/config.xml" ;

                    if (is_file($configFile)) {

                        $config_raw = preg_replace(array('/\t/', '/\R/'), '', file_get_contents($configFile));

                        $config = new SimpleXMLElement($config_raw);

                        $data = json_encode($config->module);
                        $data = json_decode($data, true);

                        $moduleOld = $this->modules->get(array("module_id" => $folderItem));

                        if ($moduleOld) {
                            if($this->isMoreRecent(explode('.', $data['version'], 3), explode('.', $moduleOld->version, 3))){
                                $toUpdate[] = array("module_id"=>$data['module_id'], "name"=>$data['name']);
                            }
                        } else {
                            $toInstall[] = array("module_id"=>$data['module_id'], "name"=>$data['name']);
                        }
                    }
                }
            }
        }

        $res = array('toInstall'=>$toInstall, 'toUpdate'=>$toUpdate);
        echo json_encode($res);
    }

    public function installModules(){


        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);

        }

        if($data) {
            $folderInstall = FCPATH . "install/";
            if ($folder = opendir($folderInstall)) {
                if($data['modules'] && is_array($data['modules'])) {
                    for($i=0;$i<sizeof($data['modules']);$i++) {
                        $folderModule = $folderInstall . $data['modules'][$i];
                        if (is_dir($folderModule) && $data['modules'][$i] != '.' && $data['modules'][$i] != '..') {

                            $this->installModule($data['modules'][$i], $folderInstall);

                        }
                    }
                }
                clearCache();
            }
        }
        echo json_encode('OK');
    }

    private function installModule($module = null, $folder = null){
        $this->load->model("Zeapps_modules", "modules");

        if($module && $folder) {
            $folderApp = FCPATH . "application/" ;

            $folderModule = $folder . $module ;

            $configFile = $folderModule . "/config.xml" ;

            if (is_file($configFile)) {

                $config_raw = preg_replace(array('/\t/', '/\R/'), '', file_get_contents($configFile));

                $config = new SimpleXMLElement($config_raw);

                $data = json_encode($config->module);
                $data = json_decode($data, true);

                if($data['dependencies'] && is_array($data['dependencies'])) {
                    $data['dependencies'] = json_encode($data['dependencies']['module']);

                    if($missing_dependencies = $this->isMissingDependencies($data['dependencies'])){
                        if(is_array($missing_dependencies)){
                            for($i=0;$i<sizeof($missing_dependencies);$i++){
                                if($this->isQueued($missing_dependencies[$i]->module_id, $missing_dependencies[$i]->version, $folder)){
                                    if(!$this->installModule($missing_dependencies[$i]->module_id, $folder)){
                                        return false;
                                    }
                                }
                                else{
                                    return false;
                                }
                            }
                        }
                        else{
                            if($this->isQueued($missing_dependencies->module_id, $missing_dependencies->version, $folder)){
                                if(!$this->installModule($missing_dependencies->module_id, $folder)){
                                    return false;
                                }
                            }
                            else{
                                return false;
                            }
                        }
                    }
                }
                else{
                    $data['dependencies'] = '';
                }

                $moduleOld = $this->modules->get(array("module_id"=>$data['module_id']));

                if($moduleOld){
                    if($this->isMoreRecent(explode('.', $data['version'], 3), explode('.', $moduleOld->version, 3))) {
                        $folderDest = $folderApp . $module;

                        if (!is_dir($folderDest)) {
                            recursive_mkdir($folderDest);
                        }

                        if (r_mvdir($folderModule, $folderDest)) {
                            rrmdir($folderModule);
                        }

                        $data['last_sql'] = $this->importSqlFrom($folderDest . '/sql', intval($moduleOld->last_sql));

                        $data['id'] = $moduleOld->id;
                        $this->modules->update($data, $data['id']);
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    $folderDest = $folderApp . $module;

                    if(!is_dir($folderDest)){
                        recursive_mkdir($folderDest);
                    }

                    if(r_mvdir($folderModule, $folderDest)){
                        rrmdir($folderModule);
                    }

                    $data['last_sql'] = $this->importSqlFrom($folderDest.'/sql', 0);

                    $this->modules->insert($data);
                    return true;
                }
            }
        }
        return false;
    }

    private function isQueued($name = null, $version = null, $folder = null){
        if($name && $version && $folder){
            $folderModule = $folder . $name ;

            $configFile = $folderModule . "/config.xml" ;

            if (is_file($configFile)) {

                $config_raw = preg_replace(array('/\t/', '/\R/'), '', file_get_contents($configFile));

                $config = new SimpleXMLElement($config_raw);

                $data = json_encode($config->module);
                $data = json_decode($data, true);

                $requirement = explode('.', $version, 3);
                $version = explode('.', $data['version'], 3);
                if ( !$this->isRequirementMet($requirement, $version) )
                {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private function isMissingDependencies($dependencies = null){
        if($dependencies){

            $this->load->model("Zeapps_modules", "modules");

            $dependencies = json_decode($dependencies);
            $missing_dependencies = [];

            if (is_array($dependencies)) {
                for ($i = 0; $i < sizeof($dependencies); $i++) {
                    $res = $this->modules->get(array("module_id" => $dependencies[$i]->module_id));
                    $requirement = explode('.', $dependencies[$i]->version, 3);
                    $version = explode('.', $res->version, 3);
                    if ( !$this->isRequirementMet($requirement, $version) )
                    {
                        array_push($missing_dependencies, $dependencies[$i]);
                    }
                }
            } else {
                $res = $this->modules->get(array("module_id" => $dependencies->module_id));
                $requirement = explode('.', $dependencies->version, 3);
                $version = explode('.', $res->version, 3);
                if ( !$this->isRequirementMet($requirement, $version) )
                {
                    array_push($missing_dependencies, $dependencies);
                }
            }
        }
        if(isset($missing_dependencies) && sizeof($missing_dependencies) > 0){
            return $missing_dependencies;
        }
        else
            return false;
    }

    private function isRequirementMet($requirement = null, $version = null){
        if($requirement && is_array($requirement) && sizeof($requirement) == 3 && $version && is_array($version) && sizeof($version) == 3){
            // ( r0 > v0 ) || ( r0 == v0 && [ r1 > v1 || ( r1 == v1 && r2 > v2 ) ] )
            if ( intval($requirement[0]) > intval($version[0]) ||
                ( intval($requirement[0]) == intval($version[0]) &&
                    ( intval($requirement[1]) > intval($version[1]) ||
                        ( intval($requirement[1]) == intval($version[1]) && intval($requirement[2]) > intval($version[2]) )
                    )
                )
            ){
                return false;
            }
            else{
                return true;
            }
        }
        return false;
    }

    private function isMoreRecent($newVersion = null, $oldVersion = null){
        if($newVersion && is_array($newVersion) && sizeof($newVersion) == 3 && $oldVersion && is_array($oldVersion) && sizeof($oldVersion) == 3){
            // ( new0 > old0 ) || ( new0 == old0 && [ new1 > old1 || ( new1 == old1 && new2 > old2 ) ] )
            if ( intval($newVersion[0]) > intval($oldVersion[0]) ||
                ( intval($newVersion[0]) == intval($oldVersion[0]) &&
                    ( intval($newVersion[1]) > intval($oldVersion[1]) ||
                        ( intval($newVersion[1]) == intval($oldVersion[1]) && intval($newVersion[2]) > intval($oldVersion[2]) )
                    )
                )
            ){
                return true;
            }
            else{
                return false;
            }
        }
        return false;
    }

    private function importSqlFrom($folder = null, $last = null){
        if($folder){

            $templine = '';
            $sqlfiles = [];

            if (is_dir($folder)) {
                $folder .= "/" ;

                if($folderOpen = opendir($folder)) {

                    while (false !== ($folderItem = readdir($folderOpen))) {
                        $file = $folder . $folderItem;

                        if (is_file($file) && $folderItem != '.' && $folderItem != '..' && str_ends_with($folderItem, ".sql")) {
                            $filename = intval(explode('.', $folderItem)[0]);

                            if($filename > $last){
                                $sqlfiles[$filename] = $file;
                            }

                        }
                    }

                    // We just want to make sure we execute sql updates in the right order
                    ksort($sqlfiles, SORT_NUMERIC);

                    foreach($sqlfiles as $filename=>$sqlfile) {

                        $handle = fopen($sqlfile, "r");
                        if ($handle) {
                            while (($line = fgets($handle)) !== false) {
                                // Skip it if it's a comment
                                if (substr($line, 0, 2) == '--' || $line == '')
                                    continue;

                                // Add this line to the current segment
                                $templine .= $line;

                                // If it has a semicolon at the end, it's the end of the query
                                if (substr(trim($line), -1, 1) == ';') {
                                    // Perform the query
                                    $this->db->query($templine);
                                    // Reset temp variable to empty
                                    $templine = '';
                                }
                            }

                            fclose($handle);
                            $last = $filename;
                        }

                    }

                }
            }

            return $last;
        }
        return false;
    }
}