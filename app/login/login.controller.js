(function () {
  'use strict';

  angular
    .module('app.login')
    .controller('loginController', loginController);

  function loginController($state,$cookies, loginServices,sharedService, SweetAlert ) {
    var vm = this;
    vm.infoUser = {user:'',pass:''};
    vm.login = login;

    active();

    function login(){
        loginServices.setLogin(vm.infoUser)
        	.then(function(res){
	            var respuesta = res.data;
	            if(respuesta.loggin){
	                sharedService.setAuth(respuesta);
	                $state.go("home");
	            }else{
                  SweetAlert.swal("Verifique Información", 'Usuario o Contraseña Incorrecta', "error");
	            }
	        })
          .catch(function(err){
            console.log(err);
          });
    }

    function active(){
      
    }

  }
})();
