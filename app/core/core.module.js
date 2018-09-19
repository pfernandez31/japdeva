(function() {
  'use strict';

  angular
    .module('app.core', [
      'ui.router',
      'ngCookies',
      'ui.bootstrap',
      'oitozero.ngSweetAlert',
      'ui.date'
    ])
    .filter('startFrom', function() {
    	return function(input, start) {
        	start = +start; //parse to int
        	return input.slice(start);
    	}
	   })
})();
