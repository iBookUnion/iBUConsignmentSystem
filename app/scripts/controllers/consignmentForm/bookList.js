'use strict';

var app = angular.module('consignmentApp');

app.controller('BookFormCtrl', ['$scope', '$modal', '$log', 'OPTIONS',
  function ($scope, $modal, $log, OPTIONS) {
    $scope.removeConsignmentItem = function (consignmentItem) {
      _.remove($scope.consignmentForm.consignments, _.matches(consignmentItem));
    };

    $scope.states = OPTIONS.bookStates;
    $scope.isAdmin = Parse.User.current();

    $scope.openBookModal = function (consignmentItem) {
      $scope.modalInstance = $modal.open({
        templateUrl: 'views/consignmentForm/bookModal.html',
        controller: 'BookFormModalCtrl',
        resolve: {
          existingConsignmentItem: function () {
            return consignmentItem;
          },
          consignmentForm: function () {
            console.log($scope.consignmentForm);
            return $scope.consignmentForm;
          },
          consignor: function () {
            return $scope.consignor;
          }
        }
      });

      $scope.modalInstance.result.then(function (consignedBook) {
        $scope.consignedBook = consignedBook;
      }, function () {
        $log.info('Modal dismissed at: ' + new Date());
      });
    };
  }]);