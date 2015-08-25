'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', '$location', 'ConsignmentService', 'ContractService', 'OPTIONS',
    function ($scope, $location, ConsignmentService, ContractService, OPTIONS) {
      var consignment = ConsignmentService.createNewForm();

      $scope.consignment = consignment;
      $scope.faculties = OPTIONS.faculties;

      $scope.submitForm = function (form) {
        $scope.flag = true;
        console.log(form);
        ConsignmentService.submitForm(form)
          .then(function (response) {
            $scope.flag = false;
            console.log(response);
            // set contract to be accessible through ContractService
            ContractService.setContract(response);
            $location.path('/contract');
          },
          function (error) {
            $scope.flag = false;
            // if form submission fails, then...(TODO)
            console.log(error);
            $location.path('/contract');
          });
      };
    }]);