(function() {
    'use strict';
  
    angular
      .module('app.edit')
      .config(config);
  
    /* @ngInject */
    function config($stateProvider) {
      $stateProvider
        .state('edit', {
          url: '/editar/',
          templateUrl: 'app/add/edit/edit.html',
          controller: 'editController',
          controllerAs: 'vm',
          cache: false
        })
    }
  })();
  