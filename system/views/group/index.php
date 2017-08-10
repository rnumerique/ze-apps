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
            <table class="table table-striped table-condensed table-responsive" ng-show="groups.length">
                <thead>
                <tr>
                    <th i8n="Nom"></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="group in groups">
                    <td><a href="/ng/com_zeapps/groups/view/{{group.id}}">{{group.name}}</a></td>
                    <td class="text-right">
                        <button type="button" class="btn btn-danger btn-xs" ng-click="delete(group.id)">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>