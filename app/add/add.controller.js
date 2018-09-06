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
    vm.traslapes = [];
    vm.parametrosInscripcion = [];
    vm.cantones = [];
    vm.distritos = [];
    vm.chooseRazon = chooseRazon;
    vm.chooseParam = chooseParam;
    vm.chooseTraslape = chooseTraslape;
    vm.antecedentes = {};
    vm.selecDistritos = selecDistritos;
    vm.antecedentes.movHistoricos = [];
    vm.addNewMovH = addNewMovH;
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

    function chooseParam(){
      vm.antecedentes.parametros_inscripcion = [];
      angular.forEach(vm.parametrosInscripcion, function(value, key) { 
        if(value.checked){
          var obj = { "id":value.id ,"parametro":value.razon }
          vm.antecedentes.parametros_inscripcion.push(obj);
        }
      });
    }

    function chooseTraslape(){
      vm.antecedentes.traslapes = [];
      angular.forEach(vm.traslapes, function(value, key) { 
        if(value.checked){
          var obj = { "id":value.id ,"traslape":value.razon, "tipo": value.tipo }
          vm.antecedentes.traslapes.push(obj);
        }
      });
    }

    function send(){
      alert("datos enviados");
    }

    function addNewMovH(){
      vm.antecedentes.movHistoricos.push({mov:''});
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
      //SELECT PARAMETROS INSCRIPCION FINCA
      addServices.getParametros().then(function(data){
        vm.parametrosInscripcion = data.data;
      });
      //CANTONES
      addServices.getCantones(7).then(function(data){
        vm.cantones = data.data;
      });
      //DISTRITOS
      addServices.getDistritos(1).then(function(data){
        vm.distritos = data.data;
      });
      //TRASLAPES ASP/OTRO
      addServices.getTraslapes().then(function(data){
        vm.traslapes = data.data;
      });
      //DEFAUTL
      vm.antecedentes.canton = '1';
      vm.antecedentes.distrito = '1';
      vm.antecedentes.razon = '';
      vm.antecedentes.opcParametro = '';
      vm.antecedentes.movHistoricos.push({mov:''});
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
