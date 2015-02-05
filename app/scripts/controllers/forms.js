'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:FormsCtrl
 * @description
 * # FormsCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('FormsCtrl', ['$scope', '$routeParams', '$location', function ($scope, $routeParams, $location) {

    if ($routeParams.isbn) {
      $scope.isbn = $routeParams.isbn;
    }

    $scope.viewConsignor = function() {
      console.log(this.consignor);
      $location.path('/admin/consignorInfo/' + this.consignor.studentId);
    }

    $scope.consignors = [
      {
        studentId: 12345678,
        firstName: "Susan",
        lastName: "Doe"
      },
      {
        studentId: 31462842,
        firstName: "Lisa",
        lastName: "Li"
      },
      {
        studentId: 12491122,
        firstName: "Tim",
        lastName: "Cheung"
      }
    ];
  }]);
