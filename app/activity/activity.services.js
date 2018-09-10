(function () {
    'use strict';

    angular
        .module('app.activity')
        .factory('activityServices', activityServices);

    /* @ngInject */
    function activityServices(PATHSERVICE, $http) {

        var service = {
            path: PATHSERVICE,
            getActivity: getActivity
        };
        return service;

        function getActivity(){
            var link = service.path+"data/getactivity.php";
            var getRequest = {
                method: 'GET',
                url: link,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            return $http(getRequest);
        }

    }

})();