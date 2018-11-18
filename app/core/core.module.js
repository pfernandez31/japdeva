(function() {
  'use strict';

  angular
    .module('app.core', [
      'ui.router',
      'ngCookies',
      'ui.bootstrap',
      'oitozero.ngSweetAlert',
      'ui.date',
      'angularMoment',
      'datetime'
    ])
    .filter('startFrom', function() {
    	return function(input, start) {
        	start = +start; //parse to int
        	return input.slice(start);
    	}
	   })
    .run(function(amMoment) {
      amMoment.changeLocale('es');
    })
    .constant('angularMomentConfig', {
        timezone: 'America/Costa_Rica'
    })
})();
