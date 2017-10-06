<div class="modal-header">
    <h3 class="modal-title">{{::title}}</h3>
</div>

<div class="modal-body">
    <div ng-include="template"></div>
</div>

<div class="modal-footer">
    <button class="btn btn-danger btn-sm" type="button" ng-click="cancel()">Annuler</button>
    <button class="btn btn-success btn-sm" type="button" ng-click="save()">Valider</button>
</div>