<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">Résultats de la recherche</div>
<div id="content">

    <div class="search_module" ng-repeat="(module, categories) in searchResults">
        <h4>{{module}}</h4>
        <div class="search_category" ng-repeat="(category, hits) in ::categories">
            <h5>{{category}}</h5>
            <ul class="search_results">
                <li ng-repeat="hit in ::hits">
                    <a ng-href="{{hit.url}}">
                        {{hit.label}}
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>