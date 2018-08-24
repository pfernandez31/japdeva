(function() {
  'use strict';

  angular
    .module('app.home')
    .config(config);

  /* @ngInject */
  function config($stateProvider) {
    $stateProvider
      .state('home', {
        url: '/home/',
        templateUrl: 'app/home/home.html',
        controller: 'homeController',
        controllerAs: 'vm',
        cache: false
      })
  }
})();
