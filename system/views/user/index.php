<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > <span i8n="Utilisateurs"></span></div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <a href="/ng/com_zeapps/users/view" class="btn btn-primary" i8n="Nouvel utilisateur"></a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-responsive" ng-show="users.length">
                <thead>
                <tr>
                    <th i8n="Prénom"></th>
                    <th i8n="Nom"></th>
                    <th i8n="Email"></th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="user in users">
                    <td><a href="/ng/com_zeapps/users/view/{{user.id}}">{{user.firstname}}</a></td>
                    <td><a href="/ng/com_zeapps/users/view/{{user.id}}">{{user.lastname}}</a></td>
                    <td><a href="/ng/com_zeapps/users/view/{{user.id}}">{{user.email}}</a></td>
                    <td><button type="button" class="btn btn-danger btn-sm" ng-click="delete(user.id)" i8n="Supprimer"></button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>