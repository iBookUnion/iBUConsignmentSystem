'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:ConsignorInfoCtrl
 * @description
 * # ConsignorInfoCtrl
 * Controller of the consignmentApp
 */

angular.module('consignmentApp')
  .controller('ConsignorInfoCtrl', ['$scope', '$routeParams', 'Consignors', 'ConsignmentService', 'OPTIONS',
    function ($scope, $routeParams, Consignors, ConsignmentService, OPTIONS) {

      ConsignmentService.retrieveExistingForm($routeParams.consignorId)
        .then(function (consignment) {
          $scope.consignment = consignment;
        });

      // TODO: Use some Auth library to determine if admin access is available
      $scope.isAdmin = true;
      $scope.section = 'contact';
      $scope.states = OPTIONS.bookStates;
      $scope.faculties = OPTIONS.faculties;
      $scope.consignorPayout = 0;

      $scope.selectSection = function (section) {
        $scope.section = section;
      };

      $scope.saveConsignor = function () {

      };

      $scope.$watch('consignment.form.books',
        function (newValue) {
          $scope.consignorPayout = calculateConsignorPayout(newValue);
        }, true);

      function calculateConsignorPayout(books) {
        var totalPayout = 0;
        _.forEach(books, function (book) {
          if (book.current_state === OPTIONS.bookState.sold) {
            totalPayout += book.price;
          }
        });
        return totalPayout;
      }
    }]);