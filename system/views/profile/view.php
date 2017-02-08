<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb"><span i8n="Profil de"></span> {{user.firstname+"  "+user.lastname}}</div>

<div id="content">
    <h2><i class="fa fa-3x fa-user" aria-hidden="true"></i> <span i8n="Mes préférences"></span></h2>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-responsive" >
                <thead>
                <tr>
                    <th i8n="Prénom"></th>
                    <th i8n="Nom"></th>
                    <th i8n="Mail"></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{user.firstname}}</td>
                    <td>{{user.lastname}}</td>
                    <td>{{user.email}}</td>
                    <td>
                        <div class="pull-right">
                            <button type="button" class="btn btn-primary btn-xs" ng-click="edit_profile()" i8n="Editer"></button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
</div>

<div class="modal-footer">
    <button class="btn btn-danger" type="button" ng-click="cancel()" i8n="Annuler"></button>
</div>

</div>