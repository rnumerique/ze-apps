// declare the modal to the app service
listModuleModalFunction.push({
    module_name:"com_zeapps_core",
    function_name:"search_modal",
    templateUrl:"/zeapps/directives/search_modal",
    controller:"ZeAppsCoreModalSelectionCtrl",
    size:"lg",
    resolve:{}
});

app.controller("ZeAppsCoreModalSelectionCtrl", function($scope, $uibModalInstance, option) {

    $scope.title = option.title || "Sélection" ;
    $scope.page = 1;
    $scope.pageSize = 15;
    $scope.fields = option.fields;

    $scope.select = select;
    $scope.cancel = cancel;
    $scope.update = loadItems;

    loadItems() ;

    function loadItems() {
    	var offset = ($scope.page - 1) * $scope.pageSize;
        option.http.apply(undefined, [$scope.pageSize, offset]).then(function (response) {
            if (response.data && response.data != "false") {
            	$scope.items = response.data.data;
            	$scope.total = response.data.total;
            }
        });
    }

    function select(item) {
        $uibModalInstance.close(item);
    }

    function cancel() {
        $uibModalInstance.dismiss("cancel");
    }

}) ;