'use strict';

angular.module('consignmentApp')
  .controller('ConsignmentCtrl', ['$scope', 'ConsignmentService', 'OPTIONS',
    function ($scope, ConsignmentService, OPTIONS) {


      $scope.consignment = ConsignmentService;
      $scope.faculties = OPTIONS.faculties;

      $scope.submitForm = function () {
        ConsignmentService.submitForm();
      };

      $scope.submitForm = function () {
        var form = angular.fromJson(angular.toJson($scope.consignment.form));
        Parse.Cloud.run('postConsignment', form)
          .then(function (result) {
            console.log(result);
          },
          function (error) {
            console.log(error);
          });
      };
    }]);