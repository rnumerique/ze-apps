<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends ZeCtrl
{
    private $_modules = [];

    public function index()
    {
        $this->load->model("Zeapps_users", "user");

        // verifie si la session est active
        if ($this->session->get('token')) {
            if ($this->user->getUserByToken($this->session->get('token'))) {
                $this->update_token();
                $this->appLoading();
            } else {
                header("location:/");
            }
        } else {
            header("location:/");
        }
    }

    public function home(){
        $this->load->model("Zeapps_modules", "module");
        $this->_modules = $this->module->all(array('active' => '1'));

        $this->loadCache();

        $data = $this->getMenus();

        $this->load->view("home", $data);
    }

    public function update_token()
    {
        global $globalConfig;

        $this->load->model("Zeapps_token", "token");

        $sessionLifeTime = 20;
        if (isset($globalConfig["session_lifetime"]) && is_numeric($globalConfig["session_lifetime"])) {
            $sessionLifeTime = $globalConfig["session_lifetime"];
        }

        // verifie si la session est active
        if ($this->session->get('token')) {
            $tokens = $this->token->findBy_token($this->session->get('token'));
            if ($tokens && count($tokens) == 1) {
                $tokens[0]->date_expire = date("Y-m-d H:i:s", time() + $sessionLifeTime * 60);

                $this->token->update($tokens[0], array('id' => $tokens[0]->id));
            }
        }
    }

    public function get_context(){
        $this->load->model("Zeapps_users", "user");
        $this->load->model("Zeapps_user_groups", "user_groups");
        $this->load->model("Zeapps_internationalization", "i18n");
        $this->load->model("Zeapps_hooks", "hooks");
        $this->load->model("Zeapps_configs", "config");

        $echo = [];

        // verifie si la session est active
        if ($this->session->get('token')) {
            $user = $this->user->getUserByToken($this->session->get('token'));
            if ($user && count($user) == 1) {
                $user->password = null;

                $user->i18n = [];
                if($rows = $this->i18n->all(array('id_lang' => $user->lang))){
                    foreach($rows as $row){
                        $user->i18n[$row->src] = $row->translation;
                    }
                }

                $echo['user'] = $user;
            }
        }

        if(!$echo['hooks'] = $this->hooks->all()){
            $echo['hooks'] = [];
        }

        if($debug = $this->config->get('zeapps_debug')){
            $echo['debug'] = !!intval($debug->value);
        }
        else{
            $echo['debug'] = false;
        }


        $this->trigger->set('get_context');

        $ret = $this->trigger->execute();

        if(is_array($ret) && sizeof($ret) > 0){
            foreach($ret as $result){
                if(!is_array($result)){
                    $result = array($result);
                }

                $echo = array_merge($echo, $result);
            }
        }

        echo json_encode($echo);
    }

    private function appLoading()
    {
        $this->load->model("Zeapps_modules", "module");
        $this->_modules = $this->module->all(array('active' => '1'));

        $this->loadCache();

        $data = $this->getMenus();

        $this->load->view("app", $data);
    }

    private function loadCache()
    {
        if (!is_file(FCPATH . 'cache/js/main.js') || ENVIRONMENT != 'production') {
            $this->generateMainJs();
        }

        if (!is_file(FCPATH . 'cache/css/global.css') || ENVIRONMENT != 'production') {
            $this->generateGlobalCss();
        }

        if (!is_file(FCPATH . 'cache/js/global.js') || ENVIRONMENT != 'production') {
            $this->generateGlobalJs();
        }

        $this->copyImages();

        return true;
    }

    private function getMenus()
    {
        $this->load->model("Zeapps_users", "user");
        $this->load->model("Zeapps_user_groups", "user_groups");

        $data = array();

        $space = $this->loadSpaces();

        $menus = $this->loadMenus();

        $data["menuEssential"] = $this->createEssentialMenu($menus['menuEssential']);

        $data["menuLeft"] = $this->createLeftMenu($space, $menus["menuLeft"]);

        $ret = $this->createHeaderMenu($space, $menus["menuHeader"]);

        $data['menuTopCol1'] = $ret['menuTopCol1'];
        $data['menuTopCol2'] = $ret['menuTopCol2'];

        $rights = [];

        if($user = $this->user->getUserByToken($this->session->get('token'))) {
            if ($groups = $this->user_groups->all(array('id_user' => $user->id))) {
                foreach ($groups as $group) {
                    if ($group->rights !== "") {
                        $r = json_decode($group->rights);
                        foreach ($r as $key => $value) {
                            if ($value) {
                                array_push($rights, $key);
                            }
                        }
                    }
                }
                $rights = array_unique($rights);
            }
        }

        foreach ($data['menuEssential'] as $key => $menuItem) {
            if(isset($menuItem['access'])){
                if(array_search($menuItem['access'], $rights) === false){
                    unset($data['menuEssential'][$key]);
                }
            }
        }

        foreach($data['menuLeft'] as &$menuSpace){
            foreach ($menuSpace["item"] as $key => $menuItem) {
                if(isset($menuItem['access'])){
                    if(array_search($menuItem['access'], $rights) === false){
                        unset($menuSpace["item"][$key]);
                    }
                }
            }
        }

        foreach($data['menuTopCol1'] as &$menuSpace){
            foreach ($menuSpace["item"] as $key => $menuItem) {
                if(isset($menuItem['access'])){
                    if(array_search($menuItem['access'], $rights) === false){
                        unset($menuSpace["item"][$key]);
                    }
                }
            }
        }

        foreach($data['menuTopCol2'] as &$menuSpace){
            foreach ($menuSpace["item"] as $key => $menuItem) {
                if(isset($menuItem['access'])){
                    if(array_search($menuItem['access'], $rights) === false){
                        unset($menuSpace["item"][$key]);
                    }
                }
            }
        }


        $data["form"] = true;

        return $data;
    }

    private function generateMainJs()
    {
        /*************** génération du fichier main.js dans le cache *************/
        $mainjs = "/*************\n";
        $mainjs .= "*** do not edit this files ***\n";
        $mainjs .= "*** Cache date : " . date("Y-m-d H:i:s") . " ***\n";
        $mainjs .= "*************/\n";

        if (is_file(BASEPATH . "angularjs/main.js")) { // We start with the root of our AngularJS application
            $mainjs .= minifyJS(file_get_contents(BASEPATH . "angularjs/main.js"));
            $mainjs .= "\n";
        }


        $folderApp = BASEPATH;
        if ($folder = opendir($folderApp)) {
            $folderAngularJs = $folderApp . "/angularjs";

            $mainjs .= minifyJS($this->getContentFolder($folderAngularJs, 'js'));
        }


        if ($this->_modules && is_array($this->_modules)) {
            for ($i = 0; $i < sizeof($this->_modules); $i++) {
                $folderModule = MODULEPATH . $this->_modules[$i]->module_id;
                if (is_dir($folderModule)) {
                    $folderAngularJs = $folderModule . "/angularjs";

                    $mainjs .= minifyJS($this->getContentFolder($folderAngularJs, 'js'));

                }
            }
        }

        $mainjs = minifyJs($mainjs);

        // ecriture du fichier javascript
        recursive_mkdir(FCPATH . "cache/js/");
        file_put_contents(FCPATH . "cache/js/main.js", $mainjs);
        /*************** END : génération du fichier main.js dans le cache *************/

        return true;
    }

    private function generateGlobalCss()
    {
        $globalCss = "/************\n";
        $globalCss .= "*** do not edit this files ***\n";
        $globalCss .= "*** Cache date : " . date("Y-m-d H:i:s") . " ***\n";
        $globalCss .= "*************/\n";

        /*************** copie des fichiers css *************/
        $folderApp = BASEPATH;
        if ($folder = opendir($folderApp)) {
            $folderCss = $folderApp . "/assets/css";

            $globalCss .= minifyCss($this->getContentFolder($folderCss, 'css'));
        }

        if ($this->_modules && is_array($this->_modules)) {
            for ($i = 0; $i < sizeof($this->_modules); $i++) {
                $folderModule = MODULEPATH . $this->_modules[$i]->module_id;
                if (is_dir($folderModule)) {
                    $folderCss = $folderModule . "/assets/css";

                    $globalCss .= minifyCss($this->getContentFolder($folderCss, 'css'));

                }
            }
        }
        /*************** END : copie des fichiers css *************/

        recursive_mkdir(FCPATH . "cache/css/");
        file_put_contents(FCPATH . "cache/css/global.css", $globalCss);

        return true;
    }

    private function generateGlobalJs()
    {
        $globalJs = "/************\n";
        $globalJs .= "*** do not edit this files ***\n";
        $globalJs .= "*** Cache date : " . date("Y-m-d H:i:s") . " ***\n";
        $globalJs .= "*************/\n";

        /*************** copie des fichiers css *************/
        $folderApp = BASEPATH;
        if ($folder = opendir($folderApp)) {
            $folderCss = $folderApp . "/assets/js";

            $globalJs .= $this->getContentFolder($folderCss, 'js');
        }

        if ($this->_modules && is_array($this->_modules)) {
            for ($i = 0; $i < sizeof($this->_modules); $i++) {
                $folderModule = MODULEPATH . $this->_modules[$i]->module_id;
                if (is_dir($folderModule)) {
                    $folderCss = $folderModule . "/assets/js";

                    $globalJs .= $this->getContentFolder($folderCss, 'js');

                }
            }
        }
        /*************** END : copie des fichiers css *************/

        recursive_mkdir(FCPATH . "cache/js/");
        file_put_contents(FCPATH . "cache/js/global.js", $globalJs);

        return true;
    }

    private function copyImages()
    {
        /*************** copie des fichiers images *************/
        $folderApp = BASEPATH;
        if ($folder = opendir($folderApp)) {
            while (false !== ($folderItem = readdir($folder))) {
                $folderModule = $folderApp . $folderItem;
                if (is_dir($folderModule) && $folderItem != '.' && $folderItem != '..') {
                    $folderImagesFile = $folderModule . "/assets/images";
                    if (is_dir($folderImagesFile)) {
                        $folderImagesFile .= "/";
                        if ($folderJS = opendir($folderImagesFile)) {
                            while (false !== ($folderItemImage = readdir($folderJS))) {
                                $fileJS = $folderImagesFile . $folderItemImage;
                                if (is_file($fileJS) && $folderItemImage != '.'
                                    && $folderItemImage != '..'
                                    && (
                                        str_ends_with($folderItemImage, ".png")
                                        || str_ends_with($folderItemImage, ".jpg")
                                        || str_ends_with($folderItemImage, ".gif")
                                    )
                                ) {
                                    // creation du dossier d'accueil
                                    recursive_mkdir(FCPATH . "cache/images/" . $folderItem);

                                    // copie du fichier
                                    $destination = FCPATH . "cache/images/" . $folderItem . "/" . $folderItemImage;
                                    copy($fileJS, $destination);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($this->_modules && is_array($this->_modules)) {
            $folderApp = MODULEPATH;
            if ($folder = opendir($folderApp)) {
                for ($i = 0; $i < sizeof($this->_modules); $i++) {
                    $folderModule = $folderApp . $this->_modules[$i]->module_id;
                    if (is_dir($folderModule) && $folderItem != '.' && $folderItem != '..') {
                        $folderImagesFile = $folderModule . "/assets/images";
                        if (is_dir($folderImagesFile)) {
                            $folderImagesFile .= "/";
                            if ($folderJS = opendir($folderImagesFile)) {
                                while (false !== ($folderItemImage = readdir($folderJS))) {
                                    $fileJS = $folderImagesFile . $folderItemImage;
                                    if (is_file($fileJS) && $folderItemImage != '.'
                                        && $folderItemImage != '..'
                                        && (
                                            str_ends_with($folderItemImage, ".png")
                                            || str_ends_with($folderItemImage, ".jpg")
                                            || str_ends_with($folderItemImage, ".gif")
                                        )
                                    ) {
                                        // creation du dossier d'accueil
                                        recursive_mkdir(FCPATH . "cache/images/" . $folderItem);

                                        // copie du fichier
                                        $destination = FCPATH . "cache/images/" . $folderItem . "/" . $folderItemImage;
                                        copy($fileJS, $destination);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        /*************** END : copie des fichiers images *************/
    }

    private function getContentFolder($folder, $ext)
    {
        $valRetour = "";

        if (is_dir($folder)) {
            $folder .= "/";
            if ($folderOpen = opendir($folder)) {
                while (false !== ($folderItem = readdir($folderOpen))) {
                    $file = $folder . $folderItem;
                    if (is_file($file) && $folderItem != '.' && $folderItem != '..'
                        && str_ends_with($folderItem, "." . $ext) && $folderItem != 'main.js'
                    ) {
                        $valRetour .= file_get_contents($file);
                        $valRetour .= "\n";
                    } elseif (is_dir($file) && $folderItem != '.' && $folderItem != '..') {
                        $valRetour .= $this->getContentFolder($file, $ext);
                    }
                }
            }
        }

        return $valRetour;
    }

    private function loadSpaces()
    {
        /********** charge tous les espaces **********/
        $space = array();
        $folderSpace = FCPATH . "space/";
        // charge tous les fichiers de conf des menus
        if ($folder = opendir($folderSpace)) {
            while (false !== ($folderItem = readdir($folder))) {
                $fileSpace = $folderSpace . $folderItem;
                if (is_file($fileSpace) && $folderItem != '.' && $folderItem != '..'
                    && $this->endsWith(strtolower($fileSpace), ".php")
                ) {
                    require_once $fileSpace;
                }
            }
        }
        /********** END : charge tous les espaces **********/

        return $space;
    }

    private function loadMenus()
    {
        /************ charge tous les menus de config pour les menus ***********/
        $menuLeft = array();
        $menuHeader = array();
        $menuEssential = array();

        if ($this->_modules && is_array($this->_modules)) {
            // charge tous les fichiers de conf des menus
            for ($i = 0; $i < sizeof($this->_modules); $i++) {
                $folderModule = MODULEPATH . $this->_modules[$i]->module_id;

                if (is_file($folderModule . '/config/menu.php')) {
                    require_once $folderModule . '/config/menu.php';
                }
            }
        }

        // charge tous les fichiers de conf des menus
        if (is_file(BASEPATH . 'config/menu.php')) {
            require_once BASEPATH . 'config/menu.php';
        }
        /************ END : charge tous les menus de config pour les menus ***********/

        return array(
            "menuLeft" => $menuLeft,
            "menuHeader" => $menuHeader,
            "menuEssential" => $menuEssential
        );
    }

    private function createEssentialMenu($menuEssential = array())
    {

        /*************** creation du menu essential *************/
        // charges les différents menus
        $data = array();

        // calcul le numero ordre le plus élevé
        $maxOrder = -1;
        foreach ($menuEssential as $menuItem) {
            if (isset($menuItem["order"])) {
                if ($menuItem["order"] > $maxOrder) {
                    $maxOrder = $menuItem["order"];
                }
            }
        }

        if ($maxOrder >= 0) {
            for ($iElementMenu = 0; $iElementMenu <= $maxOrder; $iElementMenu++) {
                foreach ($menuEssential as $menuItem) {
                    if (isset($menuItem["order"])) {
                        if ($menuItem["order"] == $iElementMenu) {
                            $data[] = $menuItem;
                        }
                    }
                }
            }
        }
        /*************** END : creation du menu gauche *************/

        return $data;
    }

    private function createLeftMenu($space = array(), $menuLeft = array())
    {
        /*************** creation du menu gauche *************/
        // charges les différents menus
        $data = array();
        if (isset($space)) {
            foreach ($space as $spaceItem) {
                $dataMenu = array();
                $dataMenu["info"] = $spaceItem;
                $dataMenu["item"] = array();

                // calcul le numero ordre le plus élevé
                $maxOrder = -1;
                foreach ($menuLeft as $menuLeftItem) {
                    if (isset($menuLeftItem["space"]) && isset($menuLeftItem["order"])) {
                        if ($menuLeftItem["space"] == $spaceItem["id"] && $menuLeftItem["order"] > $maxOrder) {
                            $maxOrder = $menuLeftItem["order"];
                        }
                    }
                }

                if ($maxOrder >= 0) {
                    for ($i = 0; $i <= $maxOrder; $i++) {
                        foreach ($menuLeft as $menuLeftItem) {
                            if (isset($menuLeftItem["space"]) && isset($menuLeftItem["order"])) {
                                if ($menuLeftItem["space"] == $spaceItem["id"] && $menuLeftItem["order"] == $i) {
                                    $dataMenu["item"][] = $menuLeftItem;
                                }
                            }
                        }
                    }
                }

                $data[] = $dataMenu;
            }
        }
        /*************** END : creation du menu gauche *************/

        return $data;
    }

    private function createHeaderMenu($space = array(), $menuHeader = array())
    {
        /*************** creation du menu Header *************/

        $data = array();

        $data["menuTopCol1"] = array();
        $data["menuTopCol2"] = array();

        for ($col = 1; $col <= 2; $col++) {

            // calcul le numero ordre le plus élevé
            $maxOrderCol = -1;
            if (isset($space)) {
                foreach ($space as $spaceItem) {
                    if (isset($spaceItem["menu-header"]["col"]) && isset($spaceItem["menu-header"]["order"])) {
                        if ($spaceItem["menu-header"]["col"] == $col
                            && $spaceItem["menu-header"]["order"] > $maxOrderCol
                        ) {
                            $maxOrderCol = $spaceItem["menu-header"]["order"];
                        }
                    }
                }
            }

            if ($maxOrderCol >= 0) {
                for ($iOrderSpace = 0; $iOrderSpace <= $maxOrderCol; $iOrderSpace++) {
                    foreach ($space as $spaceItem) {
                        if (isset($spaceItem["menu-header"]["col"]) && isset($spaceItem["menu-header"]["order"])) {
                            if ($iOrderSpace == $spaceItem["menu-header"]["order"]
                                && $spaceItem["menu-header"]["col"] == $col
                            ) {


                                $dataMenu = array();
                                $dataMenu["info"] = $spaceItem;
                                $dataMenu["item"] = array();

                                // calcul le numero ordre le plus élevé
                                $maxOrder = -1;
                                foreach ($menuHeader as $menuHeaderItem) {
                                    if (isset($menuHeaderItem["space"]) && isset($menuHeaderItem["order"])) {
                                        if ($menuHeaderItem["space"] == $spaceItem["id"]
                                            && $menuHeaderItem["order"] > $maxOrder
                                        ) {
                                            $maxOrder = $menuHeaderItem["order"];
                                        }
                                    }
                                }

                                if ($maxOrder >= 0) {
                                    for ($i = 0; $i <= $maxOrder; $i++) {
                                        foreach ($menuHeader as $menuHeaderItem) {
                                            if (isset($menuHeaderItem["space"]) && isset($menuHeaderItem["order"])) {
                                                if ($menuHeaderItem["space"] == $spaceItem["id"]
                                                    && $menuHeaderItem["order"] == $i
                                                ) {
                                                    $dataMenu["item"][] = $menuHeaderItem;
                                                }
                                            }
                                        }
                                    }
                                }

                                if (count($dataMenu["item"]) > 0) {
                                    if ($col == 1) {
                                        $data["menuTopCol1"][] = $dataMenu;
                                    } elseif ($col == 2) {
                                        $data["menuTopCol2"][] = $dataMenu;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        /*************** END : creation du menu Header *************/

        return $data;
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}