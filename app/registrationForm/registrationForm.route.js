(function() {
    'use strict';

    angular
        .module('app.registrationForm')
        .config(config);

    /* @ngInject */
    function config($stateProvider) {
        $stateProvider
            .state('registrationForm', {
                url: '/registrationForm/',
                templateUrl: 'app/registrationForm/registrationForm.html',
                controller: 'registrationFormController',
                controllerAs: 'vm',
                cache: false
            })
    }
})();
