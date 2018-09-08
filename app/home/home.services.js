(function () {
  'use strict';

  angular
    .module('app.home')
    .factory('homeServices', homeServices);

  /* @ngInject */
  function homeServices(PATHSERVICE, $http) {

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
   
  }

  })();