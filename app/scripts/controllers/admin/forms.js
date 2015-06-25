'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:FormsCtrl
 * @description
 * # FormsCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('FormsCtrl', ['$scope', '$routeParams', '$location', 'ConsignmentAPI', 'Books',
    function ($scope, $routeParams, $location, ConsignmentAPI, Books) {

      if ($routeParams.isbn) {
        $scope.isbn = $routeParams.isbn;
        $scope.book = Books.get({isbn : $scope.isbn},
          function(book) {
            console.log(book);
          });
      }

      ConsignmentAPI.searchConsignments({isbn: $routeParams.isbn})
        .then(function(consignments) {
          $scope.consignments = consignments;
        });

      $scope.viewConsignment = function (consignment) {
        $location.url($location.path);  // Clear query parameters
        $location.path('/admin/consignorInfo/' + consignment.studentId);
      };
    }]);