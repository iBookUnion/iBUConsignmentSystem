'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:ConsignorInfoCtrl
 * @description
 * # ConsignorInfoCtrl
 * Controller of the consignmentApp
 */

angular.module('consignmentApp')
  .controller('ConsignorInfoCtrl', ['$scope', '$routeParams',
    'ConsignmentApi', 'Consignor', 'ConsignmentService', 'OPTIONS',
    function ($scope, $routeParams,
              ConsignmentApi, Consignor, ConsignmentService, OPTIONS) {

      Consignor.get($routeParams.consignorId)
        .then(function (consignor) {
          $scope.consignor = consignor;
          return $routeParams.consignorId;
        })
        .then(ConsignmentService.retrieveExistingForm)
        .then(function (consignment) {
          $scope.consignment = consignment;
        });

      $scope.section = 'contact';
      $scope.states = OPTIONS.bookStates;
      $scope.faculties = OPTIONS.faculties;
      $scope.consignorPayout = 0;

      $scope.selectSection = function (section) {
        $scope.section = section;
      };

      $scope.saveConsignor = function () {
        // TODO: Add Loading Animation
        return ConsignmentApi.updateConsignment($scope.consignment)
          .then(function (callback) {
            console.log(callback);
          })
          .fail(function (callback) {
            console.log(callback);
          });
      };

      $scope.$watch('isAdmin');

      $scope.$watch('consignment.consignments',
        function (newValue) {
          $scope.consignorPayout = calculateConsignorPayout(newValue);
        }, true);

      function calculateConsignorPayout(books) {
        var totalPayout = 0;
        _.forEach(books, function (book) {
          if (book.currentState === OPTIONS.bookState.sold) {
            totalPayout += book.price;
          }
        });
        return totalPayout;
      }
    }]);