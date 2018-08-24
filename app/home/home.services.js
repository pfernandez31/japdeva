(function () {
  'use strict';

  angular
    .module('app.home')
    .factory('homeServices', homeServices);

  /* @ngInject */
  function homeServices(PATHSERVICE) {

    var service = {
        init:init,
        path: PATHSERVICE
    };
    return service;

    function init(){
        
    }
   
  }

  })();