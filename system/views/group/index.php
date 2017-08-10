<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > <span i8n="Groupes"></span></div>
<div id="content">


    <div class="row">
        <div class="col-md-12 text-right">
            <a href="/ng/com_zeapps/groups/view" class="btn btn-xs btn-success">
                <i class="fa fa-fw fa-plus"></i> Groupe
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-striped table-group-rights">
                <thead>
                <tr>
                    <th>Droit</th>
                    <th ng-repeat="group in groups" class="text-center">
                        {{ group.label }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat-start="module in modules" ng-if="module.rights.length" class="module-cell">
                    <td colspan="{{groups.length + 1}}">
                        {{ module.label }}
                    </td>
                </tr>
                <tr ng-repeat-end ng-repeat="(right, label) in module.rights">
                    <td>{{label}}</td>
                    <td ng-repeat="group in groups" class="text-center">
                        <input type="checkbox" ng-model="group.rights[module.module_id + right]">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>