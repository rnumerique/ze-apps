<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_config" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Paramètres" ;
$tabMenu["fa-icon"] = "cogs" ;
$tabMenu["url"] = "/ng/com_zeapps/config" ;
$tabMenu["access"] = "zeapps_admin" ;
$tabMenu["order"] = 1 ;
$menuLeft[] = $tabMenu ;

$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_modules" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Modules" ;
$tabMenu["fa-icon"] = "cubes" ;
$tabMenu["url"] = "/ng/com_zeapps/modules" ;
$tabMenu["access"] = "zeapps_admin" ;
$tabMenu["order"] = 10 ;
$menuLeft[] = $tabMenu ;

$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_users" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Utilisateurs" ;
$tabMenu["fa-icon"] = "user" ;
$tabMenu["url"] = "/ng/com_zeapps/users" ;
$tabMenu["access"] = "zeapps_admin" ;
$tabMenu["order"] = 20 ;
$menuLeft[] = $tabMenu ;



$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_groups" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Groupes" ;
$tabMenu["fa-icon"] = "users" ;
$tabMenu["url"] = "/ng/com_zeapps/groups" ;
$tabMenu["access"] = "zeapps_admin" ;
$tabMenu["order"] = 30 ;
$menuLeft[] = $tabMenu ;