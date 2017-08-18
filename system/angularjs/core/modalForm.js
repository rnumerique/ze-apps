// declare the modal to the app service
listModuleModalFunction.push({
    module_name:"com_zeapps_core",
    function_name:"form_modal",
    templateUrl:"/zeapps/directives/form_modal",
    controller:"ZeAppsCoreModalFormCtrl",
    size:"lg",
    resolve:{}
});

app.controller("ZeAppsCoreModalFormCtrl", function($scope, $uibModalInstance, option) {

    $scope.title = option.title || "Sélection" ;
    $scope.edit = option.edit;
    $scope.template = option.template;

    $scope.form = {};

    $scope.save = save;
    $scope.cancel = cancel;

    function save() {
        $uibModalInstance.close($scope.form);
    }

    function cancel() {
        $uibModalInstance.dismiss("cancel");
    }

}) ;