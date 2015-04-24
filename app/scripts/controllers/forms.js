'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:FormsCtrl
 * @description
 * # FormsCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('FormsCtrl', ['$scope', '$routeParams', '$location', '$resource', function ($scope, $routeParams, $location, $resource) {

    if ($routeParams.isbn) {
      $scope.isbn = $routeParams.isbn;
    }

    $scope.viewConsignor = function() {
      console.log(this.consignor);
      $location.path('/admin/consignorInfo/' + this.consignor.studentId);
    };

      var Users = $resource('http://timadvance.me/ibu_test/v1/users');
      $scope.consignors = Users.get().$promise.then(function (result) {
        $scope.consignors = result.users.map(function (apiConsignor) {
          var consignor = {};
          consignor.studentId = apiConsignor.student_id;
          consignor.firstName = apiConsignor.first_name;
          consignor.lastName = apiConsignor.last_name;
          return consignor;
        });
        console.log($scope.consignors);
      });
  }]);
