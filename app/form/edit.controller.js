(function () {
  'use strict';

  angular
    .module('app.form')
    .controller('editController', editController);

  function editController($state,$cookies, $stateParams, $timeout, formServices, $scope, sharedService, SweetAlert, $window) {
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
    vm.selectCheck = selectCheck;
    $scope.wizardMeta = {};
    vm.eliminar = eliminar;


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

    function eliminar(){
      SweetAlert.swal({
            title: "Eliminar Registro?", //Bold text
            text: "Desea eliminar este registro del sistema!", //light text
            type: "warning", //type -- adds appropiriate icon
            showCancelButton: true, // displays cancel btton
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si eliminar",
            closeOnConfirm: false,
            closeOnCancel: false
        }, 
        function(isConfirm){ //Function that triggers on user action.
            if(isConfirm){
              var id = vm.idAntecedente;
              var finca  = vm.antecedentes.finca;
              $window.location.href = "api/form/delete.php?id="+id+"&finca="+finca;
            }
        });
    }

    function selecDistritos(){
      var id = vm.antecedentes.canton;
       formServices.getDistritos(id).then(function(data){
        var data = data.data;
        vm.distritos = data;
      });
    }

    function update(){
		formServices.updateForm(vm.antecedentes)
			.then(function(resp){
			  var data = resp.data;
			  SweetAlert.swal("Formulario", data.success, "success");
			  $timeout(function(){ $state.go('home'); },2000);
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
          vm.valueRazones = data.checkNace;
      		vm.checkParam =  data.checkParam;
          vm.valueParametro = data.checkParam;
      		vm.checkTraslape =  data.checkTraslape;
      		vm.antecedentes = data;
      		vm.antecedentes.asesor = vm.infoUser.nombre;
      		vm.antecedentes.usuarioId = vm.infoUser.idusuario;
          vm.antecedentes.movHistoricos.push({mov:''});
      		vm. selecDistritos();
      	})
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
