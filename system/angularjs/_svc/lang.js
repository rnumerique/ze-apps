app.factory("lang", [function(){

    var lang = [];

    return {
        init: init,
        translate: translate
    };


    function init(data){
    	lang = data;
    }

    function translate(hook){
        return lang[hook] || hook;
    }

}]);