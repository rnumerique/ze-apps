app.config(['$provide',
    function ($provide) {
        $provide.decorator('zeHttp', function($delegate){
            var zeHttp = $delegate;

            var getAll_hooks = function(){
                return zeHttp.get('/zeapps/hooks/get_all');
            };

            var save_config = function(data){
                return zeHttp.post('/zeapps/config/save', data);
            };

            zeHttp.hooks = {
                get_all : getAll_hooks
            };

            zeHttp.config = angular.extend(zeHttp.config || {}, {
                save : save_config
            });

            return zeHttp;
        });
    }]);