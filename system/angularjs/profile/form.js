app.controller('ComZeAppsProfileFormCtrl', ['$scope', '$route', '$routeParams', '$location', '$rootScope', '$http',
    function ($scope, $route, $routeParams, $location, $rootScope, $http) {

        $scope.form = [];


        // charge la fiche

            $http.get('/zeapps/profile/get/' + $routeParams.id).then(function (response) {
                if (response.status == 200) {
                    $scope.form = response.data;

                    if ($scope.form.groups_list) {
                        $scope.form.groups = $scope.form.groups_list.split(",");
                    } else {
                        $scope.form.groups = [];
                    }


                    if ($scope.form.right_list) {
                        $scope.form.rights = $scope.form.right_list.split(",");
                    } else {
                        $scope.form.rights = [] ;
                    }

                }
            });






        var options = {};
        $http.post('/zeapps/group/getAll', options).then(function (response) {
            if (response.status == 200) {
                $scope.groups = response.data ;
            }
        });



        // charge la liste des droits
        $http.get('/zeapps/user/getRightList').then(function (response) {
            if (response.status == 200) {
                $scope.right_list = response.data ;
            }
        });




        $scope.enregistrer = function () {
            var $data = {} ;



            if ($scope.form.password_field && $scope.form.password_field.trim() != "") {
                $data.password = $scope.form.password_field ;
            }

            $data.firstname = $scope.form.firstname ;
            $data.lastname = $scope.form.lastname ;
            $data.email = $scope.form.email ;

            $data.groups_list = $scope.form.groups.join();
            $data.right_list = $scope.form.rights.join() ;

            $http.post('/zeapps/profile/update_user', $data).then(function (obj) {
                // pour que la page puisse être redirigé
                $location.path("/ng/com_zeapps/profile/view");
            });
        };


        $scope.annuler = function () {
            $location.path("/ng/com_zeapps/profile/view");

        }


    }]);