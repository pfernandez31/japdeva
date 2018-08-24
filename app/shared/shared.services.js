(function () {
  'use strict';

  angular
    .module('app.shared')
     .factory('sharedService', sharedService);

  /* @ngInject */
  function sharedService($cookies,$window) {

    var service = {
        setAuth: setAuth,
        getAuth: getAuth,
        logout: logout
    };
    return service;

    function setAuth(data){
      $cookies.put('loggin', true);
      window.localStorage.setItem('Auth',JSON.stringify(data));
    }

    function getAuth(){
      return  JSON.parse(window.localStorage.getItem('Auth'));
    }
    
    function logout(){
      $cookies.remove('loggin');
      window.localStorage.removeItem('Auth')
    }   
  }
  
})();
