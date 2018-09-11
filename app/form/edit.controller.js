(function () {
  'use strict';

  angular
    .module('app.form')
    .controller('editController', editController);

  function editController($state,$cookies, $stateParams, $timeout, formServices, $scope, sharedService, SweetAlert) {
    var vm = this;
    vm.infoUser = {};
    vm.exit = exit;
    vm.update = update;
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
    $scope.wizardMeta = {};


    active();

    function selecDistritos(){
      var id = vm.antecedentes.canton;
       formServices.getDistritos(id).then(function(data){
        var data = data.data;
        vm.distritos = data;
      });
    }

    function update(){
		if(vm.antecedentes.finca == null ||  vm.antecedentes.tomo == null || vm.antecedentes.folio == null || vm.antecedentes.asiento == null || vm.antecedentes.identificadorPredial == null || vm.antecedentes.razones.length <= 0 || vm.antecedentes.parametros_inscripcion.length <= 0 || vm.antecedentes.propietarioA == null || vm.antecedentes.propietario == null || vm.antecedentes.finca_inscrita_derecho == null || vm.antecedentes.asesorRegistral == null  ){
			SweetAlert.swal("Verifique Información", 'Algunos campos son requeridos(*) ', "warning");
		}
		else{
		formServices.updateForm(vm.antecedentes)
			.then(function(resp){
			  var data = resp.data;
			  console.log(data);
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
      var existe = $cookies.get('loggin');
      if(!existe){
          $state.go("login");
      }
      vm.infoUser = sharedService.getAuth();
      vm.idAntecedente = $stateParams.id;
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
      formServices.loadForm(vm.idAntecedente)
      	.then(function(resp){
      		var data = resp.data;
      		data.inscripcion = new Date(data.inscripcion);
      		data.otorgamiento = new Date(data.otorgamiento);
      		data.presentacion = new Date(data.presentacion);
      		data.ejecutoria_juzgado = new Date(data.ejecutoria_juzgado);
      		vm.checkNace =  data.checkNace;
      		vm.checkParam =  data.checkParam;
      		vm.checkTraslape =  data.checkTraslape;
      		vm.antecedentes = data;
      		vm.antecedentes.asesor = vm.infoUser.nombre;
      		vm.antecedentes.usuarioId = vm.infoUser.idusuario;
      		

      		
      		vm. selecDistritos();
      	})
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
