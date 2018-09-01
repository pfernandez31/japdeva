(function () {
  'use strict';

  angular
    .module('app.add')
    .factory('addServices', addServices);

  /* @ngInject */
  function addServices(PATHSERVICE, $http) {

    var service = {
        getRazones:getRazones,
        getProvincias:getProvincias,
        getCantones:getCantones,
        getDistritos:getDistritos,
        path: PATHSERVICE
    };
    return service;

    function getRazones(){
      var link = service.path+"data/getrazones.php";
      var getRequest = {
        method: 'GET',
        url: link,
        headers: {
          'Content-Type': 'application/json'
        }
      };
      return $http(getRequest);
    }

    function getProvincias(){
      var link = service.path+"data/getprovincias.php";
      var getRequest = {
        method: 'GET',
        url: link,
        headers: {
          'Content-Type': 'application/json'
        }
      };
      return $http(getRequest);
    }

    function getCantones(idcanton){
      var link = service.path+"data/getcanton.php";
      var getRequest = {
        method: 'GET',
        url: link,
        headers: {
          'Content-Type': 'application/json'
        },
        params: {
          id: 7
        }
      };
      return $http(getRequest);
    }

     function getDistritos(iddistrito){
      var link = service.path+"data/getdistritos.php";
      var getRequest = {
        method: 'GET',
        url: link,
        headers: {
          'Content-Type': 'application/json'
        },
        params: {
          id: iddistrito
        }
      };
      return $http(getRequest);
    }
   
  }

  })();