<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Notifications de {{user.firstname+" "+user.lastname}}</div>

<div id="content">
    <h2>Mes Notifications</h2>
    <ul class="notifications profile-notifications">
        <li ng-repeat="(moduleName, module) in notifications" ng-class="notification.status"
            ng-style="{'border-color':module.color}">
            <strong ng-style="{color:module.color}">{{moduleName}}</strong>
            <ul>
                <li ng-repeat="notification in module.notifications"
                    ng-class="notification.status ? 'bg-'+notification.status : 'bg-default'" class="notification">
                    {{ notification.message }}
                </li>
            </ul>
        </li>
        <li ng-hide="hasNotifications()" class="no-notifications">
            Aucune notifications<br>
        </li>
    </ul>
</div>