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
              if(d.id == 12){
                vm.selectOtro = false;
                vm.antecedentes.razon = '';
              } else {
                vm.selectOtro = true;
                vm.antecedentes.otrarazon = '';
                vm.antecedentes.razon = '';
              }
              break;
          case "parametros":
              vm.antecedentes.parametros_inscripcion = d.id;
              vm.valueParametro = d.id;
              if(d.id != 3){
                vm.antecedentes.opcParametro = '';
              }
              break;
          case "traslapes":
              vm.valueTraslape = d.id;
              vm.antecedentes.traslapes = d.id;
              if(d.id == 10){
                vm.selectOtroT = false;
              } else {
                vm.selectOtroT = true;
                vm.antecedentes.Traslaperazon = '';
              }
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
          closeOnCancel: true
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
      SweetAlert.swal({
          title: "Actualizar Registro", //Bold text
          text: "¿Desea actualizar la información?", //light text
          type: "warning", //type -- adds appropiriate icon
          showCancelButton: true, // displays cancel btton
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si",
          closeOnConfirm: false,
          closeOnCancel: true
        }, 
        function(isConfirm){ //Function that triggers on user action.
            if(isConfirm){
              if(vm.antecedentes.razones == '' ){ vm.antecedentes.razones = 0; }
              if(vm.antecedentes.parametros_inscripcion == '' ){ vm.antecedentes.parametros_inscripcion = 0; }
              if(vm.antecedentes.traslapes == '' ){ vm.antecedentes.traslapes = 0; }
              vm.antecedentes.inscripcion = moment.utc(vm.antecedentes.inscripcion).format("YYYY-MM-DD");
      
              if(vm.antecedentes.otorgamiento != null){
                vm.antecedentes.otorgamiento = moment.utc(vm.antecedentes.otorgamiento).format("YYYY-MM-DD");
              } else {
                 vm.antecedentes.otorgamiento = '';
              }
              
              if(vm.antecedentes.presentacion != null){
                vm.antecedentes.presentacion = moment.utc(vm.antecedentes.presentacion).format("YYYY-MM-DD");
              } else {
                vm.antecedentes.presentacion = '';
              }
              
              if(vm.antecedentes.ejecutoria_juzgado != null){
                vm.antecedentes.ejecutoria_juzgado = moment.utc(vm.antecedentes.ejecutoria_juzgado).format("YYYY-MM-DD");  
              } else {
                vm.antecedentes.ejecutoria_juzgado = '';
              }
              formServices.updateForm(vm.antecedentes)
                .then(function(resp){
                  var data = resp.data;
                  if(data.success){
                    SweetAlert.swal("Formulario", "actualizado correctamente!", "success");
                    $timeout(function(){ $state.go('home'); },500);
                  } else {
                    SweetAlert.swal("No se ha podido actualizar el formulario", "verifique la información digitada", "error");
                    console.log(data);
                  }
                  
                })
                .catch(function(err){
                  console.log(err);
                })
            }
        });
    }

    function addNewMovH(){
      vm.antecedentes.movHistoricos.push({mov:''});
    }


    function active(){
      var existe = $cookies.get('loggin');
      if(!existe){
          $state.go("login");
      }
      vm.defaultDate = new Date();
      vm.infoUser = sharedService.getAuth();
      vm.idAntecedente = $stateParams.id;
      vm.selectOtro = true;
      vm.selectOtroT = true;
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
      		vm.checkNace =  data.checkNace;
          vm.valueRazones = data.checkNace;
          if(vm.valueRazones == 12){
             vm.selectOtro = false;
          }
      		vm.checkParam =  data.checkParam;
          vm.valueParametro = data.checkParam;
          vm.valueTraslape = data.checkTraslape;
          if(vm.valueTraslape == 10){
             vm.selectOtroT = false;
          }
      		vm.checkTraslape =  data.checkTraslape;
      		vm.antecedentes = data;
      		vm.antecedentes.asesor = vm.infoUser.nombre;
      		vm.antecedentes.usuarioId = vm.infoUser.idusuario;
          vm.antecedentes.movHistoricos.push({mov:''});

          vm.antecedentes.inscripcion = new Date(data.inscripcion);
          
          if(data.otorgamiento != null){
            vm.antecedentes.otorgamiento = new Date(data.otorgamiento);
          } else { vm.antecedentes.otorgamiento = null; }
          
          if(data.ejecutoria_juzgado != null){
            vm.antecedentes.ejecutoria_juzgado = new Date(data.ejecutoria_juzgado);            
          } else { vm.antecedentes.ejecutoria_juzgado = null; }
          
          if(data.presentacion != null){
            vm.antecedentes.presentacion = new Date(data.presentacion);
          } else { vm.antecedentes.presentacion = null; }

      		vm. selecDistritos();
      	})
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
