(function () {
  'use strict';

  angular
    .module('app.form')
    .controller('newController', newController);

  function newController($state,$cookies,  formServices, $scope, sharedService, $timeout, SweetAlert) {
    var vm = this;
    vm.infoUser = {};
    vm.exit = exit;
    vm.save = save;
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
    vm.selectCheck = selectCheck;
    $scope.wizardMeta = {};


    active();

    function selectCheck(d,tipo){
      switch(tipo) {
          case "razones":
              vm.antecedentes.razones = d.id;
              vm.valueRazones = d.id;
              break;
          case "parametros":
              vm.antecedentes.parametros_inscripcion = d.id;
              vm.valueParametro = d.id;
              break;
          case "traslapes":
              vm.antecedentes.traslapes = d.id;
              break;
          default:
              
      }
      
    }

    function selecDistritos(){
      var id = vm.antecedentes.canton;
       formServices.getDistritos(id).then(function(data){
        var data = data.data;
        vm.distritos = data;
      });
    }

    function save(){
      if(vm.antecedentes.finca == '' ||   vm.antecedentes.identificadorPredial == '' || vm.antecedentes.razones == '' || vm.antecedentes.parametros_inscripcion == '' || vm.antecedentes.propietarioA == '' || vm.antecedentes.propietario == '' || vm.antecedentes.asesorRegistral == '' ){
        SweetAlert.swal("Verifique Información", 'Algunos campos son requeridos(*) ', "warning");
      }
      else{
        formServices.saveForm(vm.antecedentes)
        .then(function(resp){
          var data = resp.data;
          SweetAlert.swal("Formulario", data.success, "success");
          $timeout(function(){ $state.go('home'); },2000);
        })
        .catch(function(err){
          console.log(err);
        })
      }
      
      
    }

    function addNewMovH(){
      vm.antecedentes.movHistoricos.push({mov:''});
    }


    function active(){
       //INICIALIZAR
       vm.antecedentes.razones = '';
       vm.antecedentes.ntomo = '';
       vm.antecedentes.nasiento = '';
       vm.antecedentes.area_traslape = '';
       vm.antecedentes.pne = '';
       vm.antecedentes.traslapes = '';
       vm.antecedentes.parametros_inscripcion = '';
       vm.antecedentes.finca = '';
       vm.antecedentes.d = '';
       vm.antecedentes.derecho = '';
       vm.antecedentes.identificadorPredial = '';
       vm.antecedentes.plano = '';
       vm.antecedentes.area = '';
       vm.antecedentes.tomo = '';
       vm.antecedentes.folio = '';
       vm.antecedentes.asiento = '';
       vm.antecedentes.plazo = '';
       vm.antecedentes.notario = '';
       vm.antecedentes.juzgado = '';
       vm.antecedentes.numExpediente = '';
       vm.antecedentes.propietario = '';
       vm.antecedentes.propietarioA = '';
       vm.antecedentes.analisisCaso = '';
       vm.antecedentes.recomendacionLegal = '';
       vm.antecedentes.asesorRegistral = '';
       vm.antecedentes.asesorLegal = '';
       vm.antecedentes.finca_inscrita_derecho = '';
      var existe = $cookies.get('loggin');
      if(!existe){
          $state.go("login");
      }
      vm.infoUser = sharedService.getAuth();
      //SELECT NACE POR
      formServices.getRazones().then(function(data){
        vm.razones = data.data;
      });
      //SELECT PARAMETROS INSCRIPCION FINCA
      formServices.getParametros().then(function(data){
        vm.parametrosInscripcion = data.data;
      });
      //CANTONES
      formServices.getCantones(7).then(function(data){
        vm.cantones = data.data;
      });
      //DISTRITOS
      formServices.getDistritos(1).then(function(data){
        vm.distritos = data.data;
      });
      //TRASLAPES ASP/OTRO
      formServices.getTraslapes().then(function(data){
        vm.traslapes = data.data;
      });
      //DEFAUTL
      vm.antecedentes.usuarioId = vm.infoUser.idusuario;
      vm.antecedentes.asesor = vm.infoUser.nombre;
      vm.antecedentes.canton = '1';
      vm.antecedentes.distrito = '1';
      vm.antecedentes.razon = '';
      vm.antecedentes.otrarazon = '';
      vm.antecedentes.opcParametro = '';
      vm.antecedentes.movHistoricos.push({mov:''});
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
