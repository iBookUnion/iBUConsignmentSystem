'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', '$location', 'ConsignmentService', 'ContractService', 'OPTIONS',
    function ($scope, $location, ConsignmentService, ContractService, OPTIONS) {
      $scope.consignment = ConsignmentService.createNewForm();
      $scope.faculties = OPTIONS.faculties;

      $scope.submitForm = function (form) {
        console.log($scope.contactForm.$dirty);
        if (isCompleteConsignment(form)) { 
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
      }};
      
      function isCompleteConsignment(form) {
        if (!$scope.contactForm.$valid) {
          $scope.Msg = "Please Fill Out The Contact Form.";
          return false;
        } else if (!form.consignments.length) {
          $scope.Msg = "The Consignment Form Must Contain At Least One Book."
          return false;
        } else if (!$scope.agreement) {
        $scope.Msg = "You cannot submit the form until you accept the terms of the agreement.";
        return false;
        } else {
          return true;
        }
      }
      
      window.onbeforeunload = function (event) {
        if ($scope.contactForm.$dirty || $scope.consignment.consignments.length) {
          var message = 'Sure you want to leave?';
          if (typeof event == 'undefined') {
            event = window.event;
          }
          if (event) {
            event.returnValue = message;
          }
          return message;
        }
      }
      
    }]);