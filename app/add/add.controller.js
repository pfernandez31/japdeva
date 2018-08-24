(function () {
  'use strict';

  angular
    .module('app.add')
    .controller('addController', addController);

  function addController($state,$cookies, addServices, sharedService) {
    var vm = this;
    vm.infoUser = {};
    vm.exit = exit;
    vm.send = send;
    active();

    function send(){
      alert("datos enviados");
    }

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
