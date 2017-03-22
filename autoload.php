<?php
// load Core
require_once BASEPATH . 'core/ZeRouteur.php' ;
require_once BASEPATH . 'core/ZeDatabase.php' ;
require_once BASEPATH . 'core/ZeQuery.php' ;
require_once BASEPATH . 'core/ZeModel.php' ;
require_once BASEPATH . 'core/ZeLoad.php' ;
require_once BASEPATH . 'core/ZeInput.php' ;
require_once BASEPATH . 'core/ZeView.php' ;
require_once BASEPATH . 'core/ZeSession.php' ;
require_once BASEPATH . 'core/ZeCtrl.php' ;
require_once BASEPATH . 'core/ZeHook.php' ;

// load config file
require_once FCPATH . 'config/database.php' ;
if (is_file(FCPATH . 'config/global.php')) {
    require_once FCPATH . 'config/global.php' ;
}
