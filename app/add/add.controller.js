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
    vm.antecedentes = {};
    vm.selecDistritos = selecDistritos;
    vm.antecedentes.movHistoricos = [];
    vm.addNewMovH = addNewMovH;
    vm.valueRazones = '';
    vm.valueParametro = '';
    active();



    function selecDistritos(){
      var id = vm.antecedentes.canton;
       addServices.getDistritos(id).then(function(data){
        var data = data.data;
        vm.distritos = data;
      });
    }



    function send(){
      addServices.saveForm(vm.antecedentes)
      .then(function(resp){
        var data = resp.data;
        alert(data.success);
      })
      .catch(function(err){
        console.log(err);
      })
      
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
      vm.antecedentes.asesor = vm.infoUser.nombre;
      vm.antecedentes.canton = '1';
      vm.antecedentes.distrito = '1';
      vm.antecedentes.razones = [];
      vm.antecedentes.razon = '';
      vm.antecedentes.opcParametro = '';
      vm.antecedentes.movHistoricos.push({mov:''});
      vm.antecedentes.traslapes = [];
      vm.antecedentes.parametros_inscripcion = [];
      vm.antecedentes.razones = [];
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
