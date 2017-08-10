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

                <div class="form-group">
                    <label i8n="Taux horaire (€)"></label>
                    <input type="number" class="form-control" ng-model="form.hourly_rate">
                </div>





                <div class="form-group">
                    <label i8n="Groupes"></label>

                    <div ng-repeat="group in groups">
                        <input type="checkbox" checklist-model="form.groups" checklist-value="group.id"> {{group.name}}
                    </div>
                </div>


                <div class="form-group">
                    <label i8n="Liste des droits"></label>

                    <div ng-repeat="space in right_list">

                        <h4 style="border-bottom: solid 1px #000000;">{{space.info.name}}</h4>

                        <div ng-repeat="section in space.section">

                            <h5>{{section.info}}</h5>


                            <div ng-repeat="droit in section.item">
                                <input type="checkbox" checklist-model="form.rights" checklist-value="droit.id">
                                {{droit.label}}
                            </div>
                        </div>
                    </div>
                </div>




                <div class="text-center">
                    <button type="button" class="btn btn-success" ng-click="enregistrer()" i8n="Enregistrer"></button>
                    <button type="button" class="btn btn-warning btn-sm" ng-click="annuler()" i8n="Annuler"></button>
                </div>

            </form>
        </div>
    </div>


</div>