(function () {
  'use strict';

  angular
    .module('app.login')
    .factory('loginServices', loginServices);

  /* @ngInject */
  function loginServices(PATHSERVICE,$http) {

    var service = {
      setLogin: setLogin,
      path: PATHSERVICE
    };

    return service;

    function setLogin(data){
      var link = service.path+"session/login.php";
      return $http.post(link, { usuario: data.user, pass: data.pass });
    }
   
  }

  })();