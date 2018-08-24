(function () {
  'use strict';

  angular
    .module('app.add')
    .factory('addServices', addServices);

  /* @ngInject */
  function addServices(PATHSERVICE) {

    var service = {
        init:init,
        path: PATHSERVICE
    };
    return service;

    function init(){
        
    }
   
  }

  })();