(function() {
  'use strict';

  angular
    .module('app.core', [
      'ui.router',
      'ngCookies',
      'ui.bootstrap',
      'oitozero.ngSweetAlert',
      'ui.date',
      'angularMoment'
    ])
    .filter('startFrom', function() {
    	return function(input, start) {
        	start = +start; //parse to int
        	return input.slice(start);
    	}
	   })
    .config(function(){
      moment.locale('es', {
          relativeTime : {
            future: "hace %s",
            past:   "hace %s",
            s:  "segundos",
            m:  "un minuto",
            mm: "%d minutos",
            h:  "una hora",
            hh: "%d horas",
            d:  "un día",
            dd: "%d días",
            M:  "un mes",
            MM: "%d meses",
            y:  "a año",
            yy: "%d años"
          }
      });
    })
})();
