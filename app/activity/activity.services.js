(function () {
    'use strict';

    angular
        .module('app.activity')
        .factory('activityServices', activityServices);

    /* @ngInject */
    function activityServices(PATHSERVICE, $http) {
/*
        var service = {
            path: PATHSERVICE,
            getForms: getForms
        };
        return service;

        function getForms(){
            var link = service.path+"form/list.php";
            var getRequest = {
                method: 'GET',
                url: link,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            return $http(getRequest);
        }
*/
    }

})();