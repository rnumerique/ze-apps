app.controller("ComZeAppsSearchCtrl", ["$scope", "$routeParams", "zeHttp",
    function ($scope, $routeParams, zhttp) {

    var search = $routeParams.query || "";

    $scope.searchResults = {};

    var formatted_search = angular.toJson(search);
    zhttp.app.search(formatted_search).then(function(response){
        if(response.data && response.data !== "false"){
            $scope.searchResults = response.data.results;
        }
    });
}]);