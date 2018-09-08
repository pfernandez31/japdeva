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
    vm.pageSize = 20;
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
      homeServices.getForms()
        .then(function(resp){
          var data = resp.data;
          console.log(data);
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
