'use strict';

var app = angular.module('consignmentApp');

app.controller('BookFormCtrl', ['$scope', '$modal', '$log', 'OPTIONS',
  function ($scope, $modal, $log, OPTIONS) {
    $scope.removeConsignmentItem = function (consignmentItem) {
      _.remove($scope.consignment.form.consignments, _.matches(consignmentItem));
    };

    $scope.states = OPTIONS.bookStates;

    $scope.openBookModal = function (consignmentItem) {
      $scope.modalInstance = $modal.open({
        templateUrl: 'views/consignmentForm/bookModal.html',
        controller: 'BookFormModalCtrl',
        resolve: {
          consignmentItem: function () {
            return consignmentItem;
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

app.controller('BookFormModalCtrl', ['$scope', '$log', '$modalInstance', 'consignmentItem', 'ConsignmentService', 'Books',
  function ($scope, $log, $modalInstance, consignmentItem, ConsignmentService, Books) {

    var newConsignmentItem = {
      items: []
    };

    var previousConsignmentItem = consignmentItem;

    $scope.alertMessage = '';

    $scope.consignmentItem = consignmentItem || newConsignmentItem;

    if (!consignmentItem.items.length) {
      consignmentItem.items.push({});
    }

    $scope.consignedBook = consignmentItem.items[0];

    $scope.findBookMetadata = function (isbn) {
      Books.get({isbn: isbn}, function (book) {
        $scope.consignedBook = book;
      });
    };

    $scope.submitForm = function () {
      $log.info('Consigning book ' + $scope.consignedBook.isbn + ' for course ' + $scope.consignedBook.courses);
      if (!previousConsignmentItem) {
        ConsignmentService.form.items.push($scope.consignmentItem);
        makeAlert('Added ' + $scope.consignedBook.title + ' into your book list.');
      } else {
        makeAlert('Saved changes.');
      }
      this.resetForm();
    };

    $scope.cancel = function () {
      $modalInstance.close('cancel');
    };

    $scope.resetForm = function () {
      consignmentItem.items[0] = {};
      $scope.consignedBook = consignmentItem.items[0];
      $scope.consignForm.$setPristine();
    };

    function makeAlert(msg) {
      $scope.alertMessage = msg;
    }
  }]);