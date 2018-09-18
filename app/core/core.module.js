(function() {
  'use strict';

  angular
    .module('app.core', [
      'ui.router',
      'ngCookies',
      'ui.bootstrap',
      'ADM-dateTimePicker',
      'oitozero.ngSweetAlert'
    ])
    .filter('startFrom', function() {
    	return function(input, start) {
        	start = +start; //parse to int
        	return input.slice(start);
    	}
	   })
    .config(['ADMdtpProvider', function(ADMdtp) {
      ADMdtp.setOptions({
          format: 'DD-MM-YYYY hh:mm',
          default: 'today',
          calType: "gregorian"
      });
    }]);

})();
