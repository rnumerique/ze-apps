<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > <span i8n="Utilisateurs"></span></div>
<div id="content">


    <div class="row">
        <div class="col-md-12 text-right">
            <a href="/ng/com_zeapps/users/view" class="btn btn-xs btn-success">
                <i class="fa fa-fw fa-plus"></i> Utilisateur
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-condensed table-responsive" ng-show="users.length">
                <thead>
                <tr>
                    <th i8n="Prénom"></th>
                    <th i8n="Nom"></th>
                    <th i8n="Email"></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="user in users">
                    <td><a href="/ng/com_zeapps/users/view/{{user.id}}">{{user.firstname}}</a></td>
                    <td><a href="/ng/com_zeapps/users/view/{{user.id}}">{{user.lastname}}</a></td>
                    <td><a href="/ng/com_zeapps/users/view/{{user.id}}">{{user.email}}</a></td>
                    <td class="text-right">
                        <button type="button" class="btn btn-danger btn-xs" ng-click="delete(user.id)">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>