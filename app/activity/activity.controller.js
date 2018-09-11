(function () {
    'use strict';

    angular
        .module('app.activity')
        .controller('activityController', activityController);

    function activityController($state, $cookies, $filter, activityServices, sharedService) {
        var vm = this;
        vm.infoUser = {};
        vm.exit = exit;
        vm.listActivity = [];
        vm.currentPage = 0;
        vm.pageSize = 20;
        vm.getData = getData;
        vm.numberOfPages = numberOfPages;
        vm.q = '';
        active();

        function getData(){
            return $filter('filter')(vm.listActivity, vm.q)
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
        activityServices.getActivity()
            .then(function(resp){
                var data = resp.data;
                angular.forEach(data,function(value,key){
                     vm.listActivity.push(
                        {
                            usuario: value.usuario,
                            fecha: value.fecha,
                            accion: value.accion,
                            registro: value.registro
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