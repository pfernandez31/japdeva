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
	        filter: filter
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

	    function filter(finca,fecha,role){
	    	var link = service.path+"form/filter.php";
      		return $http.post(link, { finca: finca, fecha: fecha, role:role });
	    }
    }

})();