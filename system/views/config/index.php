<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Ze-apps > Config</div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary" ng-click="emptyCache()">Vider le cache</button>
        </div>
    </div>

    <form>

        <div class="row">
            <div class="col-md-12">
                <h3>Options de l'application</h3>
                <div class="input-group">
                    <label>
                        <input type="checkbox" ng-model="$root.debug">
                        Debug Mode
                    </label>
                </div>
            </div>
        </div>

        <form-buttons></form-buttons>

    </form>
</div>
