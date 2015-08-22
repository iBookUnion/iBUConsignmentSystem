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

      $scope.isAdmin = Parse.User.current();
      $scope.section = 'contact';
      $scope.states = OPTIONS.bookStates;
      $scope.faculties = OPTIONS.faculties;
      $scope.consignorPayout = 0;

      $scope.selectSection = function (section) {
        $scope.section = section;
      };

      $scope.saveConsignor = function () {
        return Parse.Promise.when(saveConsignor($scope.consignment.form),
          saveConsignmentItems($scope.consignment.form.consignments))
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

      function saveConsignor(consignor) {
        var consignorObject = new Parse.Object('Consignor');
        var consignorInfo = _.omit(consignor, 'consignments');
        return consignorObject
          .save(sanitizeForParse(consignorInfo))
          .fail(function (error) {
            console.log(error);
            return Parse.Promise.error(error);
          });
      }

      function saveConsignmentItems(consignmentItems) {
        return Parse.Promise.when(_.map(consignmentItems, saveConsignmentItem));

        function saveConsignmentItem(consignmentItem) {
          console.log(consignmentItem);
          var consignmentItemObject = new Parse.Object('ConsignmentItem');
          return consignmentItemObject
            .save(sanitizeForParse(consignmentItem))
            .fail(function (error) {
              console.log(error);
              return Parse.Promise.error(error);
            })
            ;
        }
      }

      // TODO: Make Utility Function out of this
      function sanitizeForParse(json) {
        return angular.fromJson(angular.toJson(json));
      }
    }]);