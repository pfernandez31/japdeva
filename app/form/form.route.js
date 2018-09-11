(function() {
  'use strict';

  angular
    .module('app.form')
    .config(config);

  /* @ngInject */
  function config($stateProvider) {
    $stateProvider
      .state('form-new', {
        url: '/form/new/',
        templateUrl: 'app/form/new.html',
        controller: 'newController',
        controllerAs: 'vm',
        cache: false
      })
      .state('form-edit', {
        url: '/form/edit/:id',
        templateUrl: 'app/form/edit.html',
        controller: 'editController',
        controllerAs: 'vm',
        cache: false
      })
  }
})();
