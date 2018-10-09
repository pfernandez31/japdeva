(function () {
    'use strict';

    angular
        .module('app.registrationForm')
        .factory('registrationFormServices', registrationFormServices);

    /* @ngInject */
    function registrationFormServices(PATHSERVICE, $http) {
    	var service = {
	        path: PATHSERVICE,
	        getForms: getForms,
	        filter: filter,
	        getUsers: getUsers
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

	    function getUsers(){
	      var link = service.path+"session/list.php";
	      var getRequest = {
	        method: 'GET',
	        url: link,
	        headers: {
	          'Content-Type': 'application/json'
	        }
	      };
	      return $http(getRequest);
	    }

	    function filter(finca,fecha,usuario){
	    	var link = service.path+"form/filter.php";
      		return $http.post(link, { finca: finca, fecha: fecha, usuario:usuario });
	    }
    }

})();