'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', 'ConsignmentService', 'OPTIONS',
    function ($scope, ConsignmentService, OPTIONS) {


      $scope.consignment = ConsignmentService;
      $scope.faculties = OPTIONS.faculties;

      $scope.submitForm = function () {
        ConsignmentService.submitForm();
      };

      $scope.$on('$routeChangeSuccess', function() {
        console.log('loaded!');
        ConsignmentService.createNewForm();
        console.log(ConsignmentService);
        $scope.consignment = ConsignmentService;
      });
    }]);