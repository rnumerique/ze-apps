app.controller('ZeAppsPopupModalDeBaseCtrl', function($scope, $uibModalInstance, $http, titre, msg, action_danger, action_primary, action_success) {


    $scope.titre = titre ;
    $scope.msg = msg ;
    $scope.action_danger = action_danger ;
    $scope.action_primary = action_primary ;
    $scope.action_success = action_success ;





    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

    $scope.action_danger_click = function () {
        $uibModalInstance.close({action:'danger'});
    };

    $scope.action_primary_click = function () {
        $uibModalInstance.close({action:'primary'});
    };

    $scope.action_success_click = function () {
        $uibModalInstance.close({action:'success'});
    };

}) ;




var listModuleModalFunction = [] ;

app.factory('zeapps_modal', ['$uibModal', function($uibModal) {
    var myServiceInstance = {};


    myServiceInstance.loadModule = function(moduleName, functionName, option, next) {

        var moduleTrouve = false ;
        for (var i = 0 ; i < listModuleModalFunction.length ; i++) {
            if (listModuleModalFunction[i].module_name == moduleName && listModuleModalFunction[i].function_name == functionName) {
                moduleTrouve = true ;

                var resolve = listModuleModalFunction[i].resolve ;
                resolve.option = option;

                var modalInstance = $uibModal.open({
                    animation: true,
                    templateUrl: listModuleModalFunction[i].templateUrl,
                    controller: listModuleModalFunction[i].controller,
                    size: listModuleModalFunction[i].size,
                    resolve: listModuleModalFunction[i].resolve
                });

                modalInstance.result.then(function (selectedItem) {
                    next(selectedItem);
                }, function () {
                    //console.log("rien");
                });

                break;
            }
        }


        if (moduleTrouve == false) {
            alert("Impossible de charger le module");
        }

    }


    // factory function body that constructs shinyNewServiceInstance
    return myServiceInstance;
}]);