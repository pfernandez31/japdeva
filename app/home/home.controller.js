(function () {
  'use strict';

  angular
    .module('app.home')
    .controller('homeController', homeController);

  function homeController($state,$cookies, homeServices, sharedService) {
    var vm = this;
    vm.infoUser = {};
    vm.exit = exit;
    active();

    function active(){
      var existe = $cookies.get('loggin');
      if(!existe){
          $state.go("login");
      }
      vm.infoUser = sharedService.getAuth();
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
