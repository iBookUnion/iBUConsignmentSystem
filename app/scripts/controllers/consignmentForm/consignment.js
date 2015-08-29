'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', '$location', 'ConsignmentService', 'ContractService', 'OPTIONS',
    function ($scope, $location, ConsignmentService, ContractService, OPTIONS) {
      $scope.consignment = ConsignmentService.createNewForm();
      $scope.faculties = OPTIONS.faculties;

      $scope.submitForm = function (form) {
        console.log($scope.agreement);
        if ($scope.agreement) { 
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
      } else {
        $scope.Msg = "You cannot submit the form until you accept the terms of the agreement.";
      }};
    }]);