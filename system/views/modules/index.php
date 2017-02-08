<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > <span i8n="Modules"></span></div>
<div id="content">

    <div class="row">
        <div class="col-md-12">
            <h3 i8n="Modules installés"></h3>
        </div>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th i8n="nom"></th>
                        <th class="text-right" i8n="version"></th>
                        <th class="text-right" i8n="actif"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="module in modules | orderBy:'version'">
                        <td>{{ module.name }}</td>
                        <td class="text-right">{{ module.version }}</td>
                        <td class="text-right"><span class="fa pointer" ng-class="testIfActif(module)" ng-click="toggleActivation(module)"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row"  ng-show="modulesToUpdate.length > 0 || modulesToInstall.length > 0">
        <div class="col-md-12">
            <h3 i8n="Modules disponibles a l'installation"></h3>
        </div>
        <div class="col-md-6" ng-show="modulesToUpdate.length > 0"  >
            <h4 i8n="Mises a jour"></h4>
            <div class="checkbox" ng-repeat="module in modulesToUpdate">
                <label>
                    <input type="checkbox" ng-model="modulesForm[module.module_id]">
                    {{module.name}}
                </label>
            </div>
        </div>
        <div class="col-md-6" ng-show="modulesToInstall.length > 0">
            <h4 i8n="Nouveaux modules"></h4>
            <div class="checkbox"  ng-repeat="module in modulesToInstall">
                <label>
                    <input type="checkbox" ng-model="modulesForm[module.module_id]">
                    {{module.name}}
                </label>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" ng-click="installModules()" i8n="Installer les modules selectionnés"></button>
        </div>
    </div>

</div>