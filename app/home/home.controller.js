(function () {
  'use strict';

  angular
    .module('app.home')
    .controller('homeController', homeController);

  function homeController($state,$cookies, $filter, homeServices, sharedService) {
    var vm = this;
    vm.infoUser = {};
    vm.exit = exit;
    vm.listAntecedentes = [];
    vm.currentPage = 0;
    vm.pageSize = 15;
    vm.getData = getData;
    vm.numberOfPages = numberOfPages;
    vm.q = '';
    active();

     function getData(){
      return $filter('filter')(vm.listAntecedentes, vm.q)
    }

    function numberOfPages(){
        return Math.ceil(vm.getData().length/vm.pageSize);                
    }

    function active(){
      var existe = $cookies.get('loggin');
      if(!existe){
          $state.go("login");
      }
      vm.infoUser = sharedService.getAuth();

      vm.listAntecedentes.push({responsable:'Japdeva Admin',finca:'21528',derecho:'111',identificador:'aaa',plano:'123',area:'456'});
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
