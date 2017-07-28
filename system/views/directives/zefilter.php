<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12 main_filters_wrap">
        <div class="pull-right form-inline">
            <span ng-show="canReset()">
                <button type="button" class="btn btn-xs btn-warning" ng-click="clearFilter()">
                    <i class="fa fa-fw fa-refresh"></i>
                </button>
            </span>
            <span ng-repeat="item in options.main">
                <span ng-if="item.format == 'input'">
                    <input type="{{item.type}}" class="form-control input-sm" ng-model="model[item.field]" placeholder="{{item.label}}">
                </span>
                <span ng-if="item.format == 'select'">
                    <label class="small">{{item.label}}</label>
                    <select ng-model="model[item.field]" class="form-control input-sm">
                        <option value="">-</option>
                        <option ng-repeat="option in item.options" value="{{option.id}}">
                            {{ option.label }}
                        </option>
                    </select>
                </span>
            </span>

            <span ng-click="shownFilter = !shownFilter" ng-show="options.secondaries.length > 0">
                <i class="fa fa-filter"></i> Filtres <i class="fa" ng-class="shownFilter ? 'fa-caret-up' : 'fa-caret-down'"></i>
            </span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="well" ng-if="shownFilter">
            <div class="row">
                <div class="col-md-{{item.size}}" ng-repeat="item in options.secondaries">
                    <div class="form-group" ng-if="item.format == 'input'">
                        <label>{{item.label}}</label>
                        <input type="{{item.type}}" class="form-control" ng-model="model[item.field]">
                    </div>
                    <div class="form-group" ng-if="item.format == 'select'">
                        <label>{{item.label}}</label>
                        <select ng-model="model[item.field]" class="form-control">
                            <option value="">-</option>
                            <option ng-repeat="option in item.options" value="{{option.id}}">
                                {{ option.label }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>