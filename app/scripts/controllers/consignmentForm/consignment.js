'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', 'ConsignmentService', 'OPTIONS',
    function ($scope, ConsignmentService, OPTIONS) {

      $scope.faculties = OPTIONS.faculties;

      $scope.consignment = ConsignmentService.getContactInfo();

      $scope.submitForm = function () {
        ConsignmentService.submitForm();
      };
    }]);