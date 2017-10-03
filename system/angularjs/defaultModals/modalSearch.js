// declare the modal to the app service
listModuleModalFunction.push({
    module_name:"com_zeapps_core",
    function_name:"search_modal",
    templateUrl:"/zeapps/directives/search_modal",
    controller:"ZeAppsCoreModalSearchCtrl",
    size:"lg",
    resolve:{}
});

app.controller("ZeAppsCoreModalSearchCtrl", ["$scope", "$uibModalInstance", "option", function($scope, $uibModalInstance, option) {

    $scope.title = option.title || "Sélection" ;
    $scope.filters = {
        main: []
    };
    $scope.template = option.template || "";
    $scope.filter_model = {};
    $scope.page = 1;
    $scope.pageSize = 15;
    $scope.fields = option.fields;

    $scope.select = select;
    $scope.cancel = cancel;
    $scope.loadList = loadList;

    loadList() ;

    angular.forEach($scope.fields, function(field){
        $scope.filters.main.push({
            format: 'input',
            field: field.key + ' LIKE',
            type: 'text',
            label: field.label
        });
    });

    function loadList() {
    	var offset = ($scope.page - 1) * $scope.pageSize;

    	if(option.filters) {
            angular.forEach(option.filters, function (value, key) {
                $scope.filter_model[key] = value;
            });
        }

        var formatted_filters = angular.toJson($scope.filter_model);

        option.http.modal($scope.pageSize, offset, formatted_filters).then(function (response) {
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

}]) ;