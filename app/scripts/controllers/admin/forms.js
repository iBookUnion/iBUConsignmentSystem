'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:FormsCtrl
 * @description
 * # FormsCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('FormsCtrl', ['$scope', '$routeParams', '$location', 'ConsignmentApi', 'Books', 'OPTIONS',
    function ($scope, $routeParams, $location, ConsignmentApi, Books, OPTIONS) {

      if ($routeParams.isbn) {
        $scope.isbn = $routeParams.isbn;
        Books.getFromParse($routeParams.isbn).then(
          function (book) {
            $scope.book = book;
          });
      }

      ConsignmentApi.searchConsignments({isbn: $routeParams.isbn})
        .then(function (consignments) {
          $scope.consignments = consignments; 
        });

      $scope.viewConsignment = function (consignment) {
        $location.url($location.path);  // Clear query parameters
        $location.path('/admin/consignorInfo/' + consignment.consignor.studentId);
      };

      $scope.states = OPTIONS.bookStates;
    }]);