(function() {
    'use strict';

    angular
        .module('app.activity')
        .config(config);

    /* @ngInject */
    function config($stateProvider) {
        $stateProvider
            .state('activity', {
                url: '/activity/',
                templateUrl: 'app/activity/activity.html',
                controller: 'activityController',
                controllerAs: 'vm',
                cache: false
            })
    }
})();
