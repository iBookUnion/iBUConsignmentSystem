'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:FormsCtrl
 * @description
 * # FormsCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('FormsCtrl', ['$scope', '$routeParams', '$location', 'ConsignmentApi', 'Book', 'OPTIONS',
    function ($scope, $routeParams, $location, ConsignmentApi, Book, OPTIONS) {

      if ($routeParams.isbn) {
        $scope.isbn = $routeParams.isbn;
        Book.get($routeParams.isbn).then(
          function (book) {
            if (!book) {
              $location.url('/admin/404');
            } else {
              $scope.book = book;
            }
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

      $scope.hexId = function (studentId) {
        var studentIdNum = Number(studentId);
        var hexString = studentIdNum.toString(16);
        return hexString;
      };

      $scope.states = OPTIONS.bookStates;
    }]);