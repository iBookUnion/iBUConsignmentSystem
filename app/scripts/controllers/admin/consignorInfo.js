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

      /**
       * This updates consignor and consignment items data. Book data are not updated.
       * All books referenced by consignment items are expected to have a Parse objectId
       * and have been already created on Parse.
       * @returns {Parse.Promise}
       */
      $scope.saveConsignor = function () {
        return Parse.Promise.when(saveContactInfo($scope.consignment.form),
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

      function saveContactInfo(consignor) {
        var consignorObject = new Parse.Object('Consignor');
        var consignorInfo = _.omit(consignor, 'consignments');
        return consignorObject
          .save(sanitizeForParse(consignorInfo))
          .fail(function (error) {
            return Parse.Promise.error(error);
          });
      }

      function saveConsignmentItems(consignmentItems) {
        return Parse.Promise.when(_.map(consignmentItems, saveConsignmentItem));

        function saveConsignmentItem(consignmentItem) {
          var serializedConsignmentItem = serializeConsignmentItem(consignmentItem);
          console.log(serializedConsignmentItem);
          var consignmentItemObject = new Parse.Object('ConsignmentItem');
          return consignmentItemObject
            .save(serializedConsignmentItem)
            .fail(function (error) {
              return Parse.Promise.error(error);
            });
        }
      }

      function serializeConsignmentItem(consignmentItem) {
        var items = consignmentItem.items;
        var consignmentItemCopy = angular.copy(consignmentItem);
        consignmentItemCopy.items = _.map(items, function (item) {
          var bookPointer = Parse.Object.extend('Book').createWithoutData(item.objectId || item.id);
          return bookPointer;
        });
        console.log(consignmentItemCopy);
        return consignmentItemCopy;
      }

      // TODO: Make Utility Function out of this
      function sanitizeForParse(json) {
        return angular.fromJson(angular.toJson(json));
      }
    }]);