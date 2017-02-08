<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_config" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Paramètres" ;
$tabMenu["url"] = "/ng/com_zeapps/config" ;
$tabMenu["order"] = 1 ;
$menuLeft[] = $tabMenu ;

$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_modules" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Modules" ;
$tabMenu["url"] = "/ng/com_zeapps/modules" ;
$tabMenu["order"] = 10 ;
$menuLeft[] = $tabMenu ;

$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_users" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Utilisateurs" ;
$tabMenu["url"] = "/ng/com_zeapps/users" ;
$tabMenu["order"] = 20 ;
$menuLeft[] = $tabMenu ;



$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_groups" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Groupes" ;
$tabMenu["url"] = "/ng/com_zeapps/groups" ;
$tabMenu["order"] = 30 ;
$menuLeft[] = $tabMenu ;