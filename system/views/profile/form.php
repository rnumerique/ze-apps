<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > <span i8n="Utilisateurs"></span></div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <form>

                <div class="form-group">
                    <label i8n="Prénom"></label>
                    <input type="text" class="form-control" ng-model="form.firstname">
                </div>

                <div class="form-group">
                    <label i8n="Nom"></label>
                    <input type="text" class="form-control" ng-model="form.lastname">
                </div>

                <div class="form-group">
                    <label i8n="Email"></label>
                    <input type="text" class="form-control" ng-model="form.email">
                </div>

                <div class="form-group">
                    <label i8n="Mot de passe"></label>
                    <input type="password" class="form-control" ng-model="form.password_field">
                </div>



                <div class="text-center">
                    <button type="button" class="btn btn-success" ng-click="enregistrer()" i8n="Enregistrer"></button>
                    <button type="button" class="btn btn-warning btn-sm" ng-click="annuler()" i8n="Annuler"></button>
                </div>

            </form>
        </div>
    </div>


</div>