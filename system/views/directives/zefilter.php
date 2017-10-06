<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12 main_filters_wrap">
        <div class="pull-right form-inline" ng-class="!isEmpty() ? 'bg-warning' : ''">
            <span ng-hide="isEmpty()" ng-click="clearFilter()">
                <i class="fa fa-fw fa-times text-warning"></i>
            </span>
            <span ng-repeat="item in filters.main">
                <span ng-if="item.format == 'input'">
                    <input type="{{::item.type}}" class="form-control input-sm" ng-model="model[item.field]" placeholder="{{::item.label}}" ng-change="update()" ng-model-options="{debounce: 250}">
                </span>
                <span ng-if="item.format == 'checkbox'">
                    <label class="small">
                        {{::item.label}}
                        <input type="checkbox" class="form-control input-sm" ng-model="model[item.field]" ng-change="update()">
                    </label>
                </span>
                <span ng-if="item.format == 'select'">
                    <label class="small">{{::item.label}}</label>
                    <select ng-model="model[item.field]" class="form-control input-sm" ng-change="update()">
                        <option value="">-</option>
                        <option ng-repeat="option in item.options" value="{{option.id}}">
                            {{::option.label}}
                        </option>
                    </select>
                </span>
            </span>

            <span ng-click="shownFilter = !shownFilter" ng-show="filters.secondaries.length > 0">
                <i class="fa fa-filter"></i> Filtres <i class="fa" ng-class="shownFilter ? 'fa-caret-up' : 'fa-caret-down'"></i>
            </span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="well" ng-if="shownFilter">
            <div class="row">
                <div class="col-md-{{::item.size}}" ng-repeat="item in filters.secondaries">
                    <div class="form-group" ng-if="item.format == 'input'">
                        <label>{{::item.label}}</label>
                        <input type="{{::item.type}}" class="form-control" ng-model="model[item.field]" ng-change="update()" ng-model-options="{debounce: 250}">
                    </div>
                    <span ng-if="item.format == 'checkbox'">
                        <label class="small">
                            <input type="checkbox" class="form-control input-sm" ng-model="model[item.field]" ng-change="update()">
                            {{::item.label}}
                        </label>
                    </span>
                    <div class="form-group" ng-if="item.format == 'select'">
                        <label>{{::item.label}}</label>
                        <select ng-model="model[item.field]" class="form-control" ng-change="update()">
                            <option value="">-</option>
                            <option ng-repeat="option in item.options" value="{{option.id}}">
                                {{::option.label}}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>