'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:FormsCtrl
 * @description
 * # FormsCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('FormsCtrl', ['$scope', '$routeParams', '$location', 'Consignors', function ($scope, $routeParams, $location, Consignors) {

    if ($routeParams.isbn) {
      $scope.isbn = $routeParams.isbn;
    }

    Consignors.get(function(payload) {
      $scope.consignors = payload.users.map(function (apiConsignor) {
        var consignor = {};
        consignor.studentId = apiConsignor.student_id;
        consignor.firstName = apiConsignor.first_name;
        consignor.lastName = apiConsignor.last_name;
        return consignor;
      });
    });

    $scope.viewConsignor = function() {
      $location.url($location.path);  // Clear query parameters
      $location.path('/admin/consignorInfo/' + this.consignor.studentId);
    };

  }]);
