app.directive('toasts', function($rootScope, $compile){
    return {
        restrict: 'E',
        link: function(scope, element, attrs){
            $rootScope.$watch('toasts', function(toasts, oldToasts){
                if(toasts != undefined && toasts != oldToasts){
                    angular.forEach(toasts, function(toast, key){
                        $compile('<div class="alert alert-'+Object.keys(toast)[0]+' alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            toast[Object.keys(toast)[0]]+
                            '</div>')(scope, function(cloned, scope){
                            element.prepend(cloned);
                            cloned.delay(10000).fadeOut(800, function(){
                                cloned.alert('close');
                            });
                        });
                        delete toasts[key];
                    });
                }
            }, true);
        }
    }
});