'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', 'ConsignmentService',
    function ($scope, ConsignmentService) {

      $scope.consignment = ConsignmentService.getContactInfo();

      $scope.submitForm = function () {
        ConsignmentService.submitForm();
      };
    }]);