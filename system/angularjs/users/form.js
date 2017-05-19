app.controller('ComZeAppsUsersFormCtrl', ['$scope', '$route', '$routeParams', '$location', '$rootScope', '$http',
    function ($scope, $route, $routeParams, $location, $rootScope, $http) {

        $scope.$parent.loadMenu("com_ze_apps_config", "com_ze_apps_users");

        var options = {};

        $scope.form = [];

        $scope.enregistrer = enregistrer;
        $scope.annuler = annuler;

        // charge la fiche
        if ($routeParams.id && $routeParams.id != 0) {
            $http.get('/zeapps/user/get/' + $routeParams.id).then(function (response) {
                if (response.status == 200) {
                    $scope.form = response.data;

                }
            });
        }

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

        function enregistrer() {
            var $data = {} ;

            if ($routeParams.id != 0) {
                $data.id = $routeParams.id;
            }

            if ($scope.form.password_field && $scope.form.password_field.trim() != "") {
                $data.password = $scope.form.password_field ;
            }

            $data.firstname = $scope.form.firstname ;
            $data.lastname = $scope.form.lastname ;
            $data.email = $scope.form.email ;

            $data.groups_list = $scope.form.groups.join();
            $data.right_list = $scope.form.rights.join() ;

            $http.post('/zeapps/user/save', $data).then(function (obj) {
                // pour que la page puisse être redirigé
                $location.path("/ng/com_zeapps/users");
            });
        }

        function annuler() {
            $location.path("/ng/com_zeapps/users");
        }

    }]);