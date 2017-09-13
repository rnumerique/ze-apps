<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="content">
    <ze-btn fa="play" color="info" hint="Démarrer l'import" always-on="true" ng-click="start()"></ze-btn>

    <div class="row">
        <div class="col-md-12">
            Step : {{step}}<br>
            Offset : {{offset}}<br>
            Total step : {{max}}
        </div>
    </div>
</div>