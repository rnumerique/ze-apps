app.directive('i8n', function($rootScope){

    var getTranslationOf = function(text){

        text = text.toLowerCase();

        if(i8n != undefined){
            if($rootScope.user !== undefined) {
                if (i8n[$rootScope.user.lang] != undefined) {
                    if (i8n[$rootScope.user.lang][$rootScope.currentModule] != undefined) {
                        if (i8n[$rootScope.user.lang][$rootScope.currentModule][text] != undefined) {
                            return i8n[$rootScope.user.lang][$rootScope.currentModule][text];
                        }
                    }
                    var translation = '';
                    angular.forEach(i8n[$rootScope.user.lang], function (arr, key) {
                        if (arr[text] != undefined && translation == '') {
                            translation = arr[text];
                        }
                    });
                    if (translation != '')
                        return translation;
                }
            }
            if(i8n[$rootScope.defaultLang] != undefined){
                if(i8n[$rootScope.defaultLang][$rootScope.currentModule] != undefined){
                    if(i8n[$rootScope.defaultLang][$rootScope.currentModule][text] != undefined){
                        return i8n[$rootScope.defaultLang][$rootScope.currentModule][text];
                    }
                }
                var translation = '';
                angular.forEach(i8n[$rootScope.defaultLang], function(arr){
                    if(arr[text] != undefined){
                        translation = arr[text];
                    }
                });
                if(translation != '')
                    return translation;
            }
        }

        return text;
    };

    return {
        restrict: 'A',
        scope: {
            i8n: '@'
        },
        link: function(scope, elm){
            elm.html(getTranslationOf(scope.i8n));
            $rootScope.$watch('user.lang', function(value, oldValue){
                if(value != undefined && value != oldValue) {
                    elm.html(getTranslationOf(scope.i8n));
                }
            });
        }
    };
});