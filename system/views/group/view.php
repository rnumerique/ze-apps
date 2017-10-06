<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > Groupes</div>
<div id="content">


    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" ng-click="create()" class="btn btn-xs btn-success">
                <i class="fa fa-fw fa-plus"></i> Groupe
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-striped table-group-rights">
                <thead>
                <tr>
                    <th>Droit</th>
                    <th ng-repeat="group in groups" class="text-center">
                        {{ group.label}} <br>
                        <ze-btn fa="pencil" color="info" hint="Editer" ng-click="edit(group)"></ze-btn>
                        <ze-btn fa="trash" color="danger" hint="Supprimer" ze-confirmation ng-click="delete(group)"></ze-btn>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="module-cell">
                    <td colspan="{{groups.length + 1}}">
                        Application
                    </td>
                </tr>
                <tr>
                    <td>Administration</td>
                    <td ng-repeat="group in groups" class="text-center">
                        <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="group.rights_array['zeapps_admin']" ng-change="save(group)">
                    </td>
                </tr>
                <tr ng-repeat-start="module in modules" ng-if="module.rights" class="module-cell">
                    <td colspan="{{groups.length + 1}}" ng-click="module.closed = !module.closed">
                        <i class="fa fa-fw" ng-class="module.closed ? 'fa-plus' : 'fa-minus'"></i>
                        Module : {{::module.label}}
                    </td>
                </tr>
                <tr ng-repeat-end ng-repeat="(right, label) in module.rights" ng-hide="module.closed">
                    <td>{{::label}}</td>
                    <td ng-repeat="group in groups" class="text-center">
                        <input type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="group.rights_array[module.module_id + '_' + right]" ng-change="save(group)">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>