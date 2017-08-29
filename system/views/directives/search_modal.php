<div class="modal-header">
    <ze-btn class="pull-right" fa="plus" color="success" hint="Nouveau" always-on="true" ng-if="template"
            ze-modalform="select"
            data-template="template"></ze-btn>
    <h3 class="modal-title">{{ title }}</h3>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="text-center" ng-show="total > pageSize">
                <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
                    class="pagination-sm" boundary-links="true" max-size="9"
                    previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-condensed table-responsive" ng-show="items.length">
                <thead>
                <tr>
                    <th ng-repeat="field in fields">
                        {{ field.label }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="item in items" ng-click="select(item)">
                    <td ng-repeat="field in fields">
                        {{ item[field.key] }}
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center" ng-show="total > pageSize">
                <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
                    class="pagination-sm" boundary-links="true" max-size="9"
                    previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-danger btn-sm" type="button" ng-click="cancel()">Annuler</button>
</div>