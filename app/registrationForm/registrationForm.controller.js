(function () {
  'use strict';

  angular
    .module('app.registrationForm')
    .controller('registrationFormController', registrationFormController);

  function registrationFormController($state,$cookies, $filter, registrationFormServices, SweetAlert, sharedService) {
    var vm = this;
    vm.infoUser = {};
    vm.exit = exit;
    vm.listAntecedentes = [];
    vm.currentPage = 0;
    vm.pageSize = 10;
    vm.getData = getData;
    vm.numberOfPages = numberOfPages;
    vm.filter = {};
    vm.listUsuarios = [];
    vm.optionsDatePickert = {
      changeYear: true,
      changeMonth: true,
      dateFormat: 'dd-mm-yy'
    }
    vm.filtrar = filtrar;
    vm.btnFinca = btnFinca;
    vm.btnFecha = btnFecha;
    vm.btnUsuario = btnUsuario;

    function btnFinca(){
      vm.filter.fecha = '';
      vm.filter.usuario = '0';
    }
    function btnFecha(){
      vm.filter.finca = '';
      vm.filter.usuario = '0';
    }
    function btnUsuario(){
      vm.filter.fecha = '';
      vm.filter.finca = '';
    }

    active();

    function filtrar(){
      vm.listAntecedentes = [];
      console.log(vm.filter.usuario);
      registrationFormServices.filter(vm.filter.finca,vm.filter.fecha, vm.filter.usuario)
        .then(function(resp){
          var data = resp.data;
          if(data.length >= 1){
            angular.forEach(data,function(value,key){
              var fechaInscripcion = new Date(value.fecha_inscripcion);
               vm.listAntecedentes.push(
                  {
                    usuarioid: value.usuarioid,
                    idAntecedente: value.id,
                    responsable: value.asesor,
                    finca: value.finca,
                    derecho: value.derecho,
                    identificador: value.identificador_predial,
                    plano: value.plano,
                    area: value.area,
                    fecha_inscripcion: fechaInscripcion
                  }
                );
            })
          }
          else{
            SweetAlert.swal("Información", "No hemos encontrado resultados", "error");
            vm.filter.finca = '';
            vm.filter.fecha = '';
            vm.filter.usuario = '0';
            active();
          }
        })
        .catch(function(err){
          console.log(err);
        });
    }

    function getData(){
      return $filter('filter')(vm.listAntecedentes)
    }

    function numberOfPages(){
        return Math.ceil(vm.getData().length/vm.pageSize);                
    }

    function active(){
      var existe = $cookies.get('loggin');
      if(!existe){
          $state.go("login");
      }

      vm.filter.finca = '';
      vm.filter.fecha = '';
      vm.filter.usuario = '0';

      vm.infoUser = sharedService.getAuth();

      registrationFormServices.getUsers()
        .then(function(resp){
          var data = resp.data;
          vm.listUsuarios = data;
        })
        .catch(function(err){
          console.log(err);
        });

      registrationFormServices.getForms()
        .then(function(resp){
          var data = resp.data;
          angular.forEach(data,function(value,key){
            var fechaInscripcion = new Date(value.fecha_inscripcion);
             vm.listAntecedentes.push(
                {
                  usuarioid: value.usuarioid,
                  idAntecedente: value.id,
                  responsable: value.asesor,
                  finca: value.finca,
                  derecho: value.derecho,
                  identificador: value.identificador_predial,
                  plano: value.plano,
                  area: value.area,
                  fecha_inscripcion: fechaInscripcion
                }
              );
          })
        })
        .catch(function(err){
          console.log(err);
        });
    }

    function exit() {
      sharedService.logout();
      $state.go("login");
    }

  }
})();
