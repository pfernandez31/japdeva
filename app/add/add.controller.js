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
    vm.razones = [];
    vm.cantones = [];
    vm.distritos = [];
    vm.chooseRazon = chooseRazon;
    vm.antecedentes = {};
    vm.selecDistritos = selecDistritos;
    active();

    function selecDistritos(){
      var id = vm.antecedentes.canton;
       addServices.getDistritos(id).then(function(data){
        var data = data.data;
        vm.distritos = data;
      });
    }

    function chooseRazon(){
      vm.antecedentes.razones = [];
      angular.forEach(vm.razones, function(value, key) { 
        if(value.checked){
          var obj = { "id":value.id ,"razon":value.razon }
          vm.antecedentes.razones.push(obj);
        }
      });
    }

    function send(){
      alert("datos enviados");
    }

    function active(){
      var existe = $cookies.get('loggin');
      if(!existe){
          $state.go("login");
      }
      vm.infoUser = sharedService.getAuth();
      //SELECT NACE POR
      addServices.getRazones().then(function(data){
        vm.razones = data.data;
      });
      //CANTONES
      addServices.getCantones(7).then(function(data){
        var data = data.data;
        vm.cantones = data;
      });
      //DISTRITOS
      addServices.getDistritos(1).then(function(data){
        var data = data.data;
        vm.distritos = data;
      });
      //DEFAUTL
      vm.antecedentes.canton = '1';
      vm.antecedentes.distrito = '1';
      vm.antecedentes.razon = '';
      //
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
