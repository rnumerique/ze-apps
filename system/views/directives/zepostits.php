<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <table class="col-xs-12 text-center postits">
        <tr>
            <td ng-repeat="postit in postits">
                <div class="postit" ng-style="postit.bg_color ? {'background-color': postit.bg_color} : {}">
                    <h3 ng-style="postit.color ? {'color': postit.color} : {}"
                        ng-bind-html="postit.value | postitFilter : postit.filter : postit.filter_options | trusted">
                    </h3>
                    <h5 ng-style="postit.legend_color ? {'color': postit.legend_color} : {}">
                        {{ postit.legend }}
                    </h5>
                </div>
            </td>
        </tr>
    </table>
</div>