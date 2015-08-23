'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', '$location', 'ConsignmentService', 'ContractService', 'OPTIONS',
    function ($scope, $location, ConsignmentService, ContractService, OPTIONS) {

      $scope.consignment = ConsignmentService;
      $scope.faculties = OPTIONS.faculties;

      $scope.submitForm = function (form) {
        $scope.flag = true;
        console.log(form);
        ConsignmentService.submitForm(form)
          .then(function (response) {
            $scope.flag = false;
            console.log(response);
            // set contract to be accessible through ContractService
            console.log(response);
            ContractService.setContract(response);
            $location.path('/contract');
          },
          function (error) {
            $scope.flag = false;
            // if form submission fails, then...(TODO)
            console.log(error);
            $location.path('/contract');
          })
      };

      $scope.$on('$routeChangeSuccess', function () {
        ConsignmentService.createNewForm();
        $scope.consignment = ConsignmentService;
      });
    }]);