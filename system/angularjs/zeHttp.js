app.factory('zeHttp', function($rootScope, $http, $q){

    var methods = ['get', 'post', 'put', 'delete', 'patch', 'head'];
    $rootScope.httpRequestCount = 0;

    var _http = function(config){
        $rootScope.httpRequestCount++;

        var defer = $q.defer();
        config = config || {};
        $http(config).then(
            function(resolve){
                $rootScope.httpRequestCount--;
                defer.resolve(resolve);
            },
            function(reject){
                $rootScope.httpRequestCount--;
                defer.reject(reject);
            },
            defer.notify
        );

        var promise = defer.promise;

        // recreate the success/error methods
        promise.success = function(fn){
            promise.then(function(response){
                fn(response.data, response.status, response.headers, config);
            });
            return promise;
        };
        promise.error = function(fn){
            promise.then(function(response){
                console.log('success callback');
                fn(response.data, response.status, response.headers, config);
            });
            return promise;
        };

        return promise;
    };

    var http = function(){
        return _http;
    };

    methods.forEach(function(method){
        http[method] = function(url, config) {
            if(typeof config !== 'string')
                config = angular.toJson(config);
            return _http({
                method: method,
                url: url,
                data: config
            });
        };
    });

    return http;
});