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
    'Consignors', 'ConsignmentApi', 'ConsignmentService', 'OPTIONS',
    function ($scope, $routeParams,
              Consignors, ConsignmentApi, ConsignmentService, OPTIONS) {

      ConsignmentService.retrieveExistingForm($routeParams.consignorId)
        .then(function (consignment) {
          $scope.consignment = consignment;
        });

      $scope.isAdmin = Parse.User.current();
      $scope.section = 'contact';
      $scope.states = OPTIONS.bookStates;
      $scope.faculties = OPTIONS.faculties;
      $scope.consignorPayout = 0;

      $scope.selectSection = function (section) {
        $scope.section = section;
      };

      $scope.saveConsignor = function () {
        return ConsignmentApi.updateConsignment($scope.consignment.form)
          .then(function (callback) {
            console.log(callback);
          })
          .fail(function (callback) {
            console.log(callback);
          });
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