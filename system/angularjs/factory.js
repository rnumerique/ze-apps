app.config(['$provide',
    function ($provide) {
        $provide.decorator('zeHttp', function($delegate){
            var zeHttp = $delegate;

            var save_config = function(data){
                return zeHttp.post('/zeapps/config/save', data);
            };

            zeHttp.config = angular.extend(zeHttp.config || {}, {
                save : save_config
            });

            return zeHttp;
        });
    }]);