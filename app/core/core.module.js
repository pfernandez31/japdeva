(function() {
  'use strict';

  angular
    .module('app.core', [
      'ui.router',
      'ngCookies',
      'ui.bootstrap'
    ])
    .filter('startFrom', function() {
    	return function(input, start) {
        	start = +start; //parse to int
        	return input.slice(start);
    	}
	});

})();
