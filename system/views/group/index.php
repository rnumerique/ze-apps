<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > <span i8n="Groupes"></span></div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <a href="/ng/com_zeapps/groups/view" class="btn btn-primary" i8n="Nouveau groupe"></a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-responsive" ng-show="groups.length">
                <thead>
                <tr>
                    <th i8n="Nom"></th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="group in groups">
                    <td><a href="/ng/com_zeapps/groups/view/{{group.id}}">{{group.name}}</a></td>
                    <td><button type="button" class="btn btn-danger btn-sm" ng-click="delete(group.id)" i8n="Supprimer"></button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>