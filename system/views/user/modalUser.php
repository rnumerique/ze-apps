<div class="modal-header">
    <h3 class="modal-title">{{titre}}</h3>
</div>


<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-responsive" ng-show="users.length">
                <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="user in users">
                    <td><a href="#" ng-click="loadUser(user.id)">{{user.firstname}}</a></td>
                    <td><a href="#" ng-click="loadUser(user.id)">{{user.lastname}}</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-danger" type="button" ng-click="cancel()">Annuler</button>
</div>