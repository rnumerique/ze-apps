<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > Utilisateurs</div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <form>

                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" class="form-control" ng-model="form.firstname">
                </div>

                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" class="form-control" ng-model="form.lastname">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" ng-model="form.email">
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" class="form-control" ng-model="form.password_field">
                </div>



                <div class="text-center">
                    <button type="button" class="btn btn-success" ng-click="enregistrer()">Enregistrer</button>
                    <button type="button" class="btn btn-warning btn-sm" ng-click="annuler()">Annuler</button>
                </div>

            </form>
        </div>
    </div>


</div>