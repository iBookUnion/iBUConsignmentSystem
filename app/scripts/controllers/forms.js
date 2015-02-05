'use strict';

/**
 * @ngdoc function
 * @name iBUAdminApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the iBuadminApp
 */
angular.module('consignmentApp')
  .controller('FormsCtrl', ['$scope', '$routeParams', '$location', function ($scope, $routeParams, $location) {

    if ($routeParams.isbn) {
      $scope.isbn = $routeParams.isbn;
    }

    $scope.viewConsignor = function() {
      console.log(this.consignor);
      $location.path('/consignor/' + this.consignor.studentId);
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
