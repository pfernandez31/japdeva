(function() {
  'use strict';

  angular
    .module('app.add')
    .config(config);

  /* @ngInject */
  function config($stateProvider) {
    $stateProvider
      .state('add', {
        url: '/nuevo/',
        templateUrl: 'app/add/add.html',
        controller: 'addController',
        controllerAs: 'vm',
        cache: false
      })
  }
})();
