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

app.controller('BookFormModalCtrl', ['$scope', '$log', '$modalInstance', 'existingConsignmentItem', 'consignmentForm', 'Books',
  function ($scope, $log, $modalInstance, existingConsignmentItem, consignmentForm, Books) {

    var openedConsignmentItem = angular.copy(existingConsignmentItem) || createNewConsignmentItem();
    $scope.consignmentItem = openedConsignmentItem; // bind the consignment item to scope
    bindNewOrExistingBook();

    $scope.alertMessage = '';

    $scope.findBookMetadata = function (isbn) {
      Books.get({isbn: isbn}, function (book) {
        $scope.consignedBook = book;
      });
    };

    $scope.submitForm = function () {
      $log.info('Consigning book ' + $scope.consignedBook.isbn + ' for course ' + $scope.consignedBook.courses);
      
      var bundledItems = angular.copy(openedConsignmentItem);
      for (var i = 0; i < bundledItems.items.length; i++) {
        bundledItems.items[i].courses = bundledItems.courses;
      };
      var formattedConsignment = {'items': bundledItems.items, 'price': bundledItems.price};
      
      if (!existingConsignmentItem) {
        ConsignmentService.form.consignments.push(formattedConsignment);
        makeAlert('Added ' + $scope.consignedBook.title + ' into your book list.');
      } else {
        _.merge(existingConsignmentItem, formattedConsignment);
        makeAlert('Saved changes.');
      }
      this.resetForm();
    };

    $scope.cancel = function () {
      $modalInstance.close('cancel');
    };

    $scope.resetForm = function () {
      openedConsignmentItem = createNewConsignmentItem();
      openedConsignmentItem.items[0] = {};
      $scope.consignmentItem = openedConsignmentItem;
      $scope.consignedBook = openedConsignmentItem.items[0];
      $scope.consignForm.$setPristine();
      $scope.consignForm.$setUntouched();
    };

    $scope.addItem = function () {
      $scope.consignmentItem.items.push({});
    };

    $scope.removeItem = function(i) {
      $scope.consignmentItem.items.splice(i,1);
    }

    function makeAlert(msg) {
      $scope.alertMessage = msg;
    }

    function createNewConsignmentItem () {
      return {
        items: []
      };
    }

    function bindNewOrExistingBook() {
      if (!openedConsignmentItem.items.length) {
        openedConsignmentItem.items.push({});
      }
      $scope.consignedBook = openedConsignmentItem.items[0];
    }
  }]);
