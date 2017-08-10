<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > <span i8n="Groupes"></span></div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <form>

                <div class="form-group">
                    <label i8n="Nom"></label>
                    <input type="text" class="form-control" ng-model="form.label">
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-success" ng-click="enregistrer()" i8n="Enregistrer"></button>
                    <button type="button" class="btn btn-warning btn-sm" ng-click="annuler()" i8n="Annuler"></button>
                </div>

            </form>
        </div>
    </div>


</div>