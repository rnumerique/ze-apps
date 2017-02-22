// declare the modal to the app service
listModuleModalFunction.push({
    module_name:'com_zeapps_core',
    function_name:'search_user',
    templateUrl:'/zeapps/user/modal_user',
    controller:'ZeAppsCoreModalUserCtrl',
    size:'lg',
    resolve:{
        titre: function () {
            return 'Recherche d\'un utilisateur';
        }
    }
});


app.controller('ZeAppsCoreModalUserCtrl', function($scope, $uibModalInstance, $http, titre, option) {
    $scope.titre = titre ;


    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };



    var loadList = function () {
        var options = {};
        $http.post('/zeapps/user/getAll', options).then(function (response) {
            if (response.status == 200) {
                $scope.users = response.data ;
            }
        });
    };
    loadList() ;


    $scope.loadUser = function (id_user) {

        // search the user
        var user = false ;
        for (var i = 0 ; i < $scope.users.length ; i++) {
            if ($scope.users[i].id == id_user) {
                user = $scope.users[i] ;
                break;
            }
        }

        $uibModalInstance.close(user);
    }

}) ;