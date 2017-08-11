<div class="modal-header">
    <h3 class="modal-title">{{titre}}</h3>
</div>


<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form>

                <div class="form-group">
                    <label i8n="Nom"></label>
                    <input type="text" class="form-control" ng-model="form.label">
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-danger" type="button" ng-click="cancel()" i8n="Annuler"></button>
    <button class="btn btn-success" type="button" ng-click="save()" i8n="Valider"></button>
</div>