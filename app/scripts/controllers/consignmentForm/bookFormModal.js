'use strict';

angular.module('consignmentApp')
  .controller('BookFormModalCtrl', ['$scope', '$modalInstance',
    'existingConsignmentItem', 'consignmentForm', 'saveBookOnSubmit', 'Book',
    function ($scope, $modalInstance,
              existingConsignmentItem, consignmentForm, saveBookOnSubmit, Book) {

      var openedConsignmentItem = angular.copy(existingConsignmentItem) || createNewConsignmentItem();
      $scope.consignmentItem = openedConsignmentItem; // bind the consignment item to scope
      bindNewOrExistingBook();

      $scope.alertMessage = '';

      $scope.findBookMetadata = function (isbn) {
        Book.get({isbn: isbn}, function (book) {
          $scope.consignedBook = book;
        });
      };

      $scope.submitForm = function () {
        var bundledItems = angular.copy(openedConsignmentItem);
        for (var i = 0; i < bundledItems.items.length; i++) {
          bundledItems.items[i].courses = bundledItems.courses;
        }
        var formattedConsignment = {'items': bundledItems.items, 'price': bundledItems.price};

        if (!existingConsignmentItem) {
          consignmentForm.consignments.push(formattedConsignment);
          makeAlert('Added consignment into your book list.');
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
        $scope.consignmentItem.items.push(new Book());
      };

      $scope.removeItem = function (i) {
        $scope.consignmentItem.items.splice(i, 1);
      };

      function makeAlert(msg) {
        $scope.alertMessage = msg;
      }

      function createNewConsignmentItem() {
        return {
          items: []
        };
      }

      function bindNewOrExistingBook() {
        if (!openedConsignmentItem.items.length) {
          openedConsignmentItem.items.push(new Book());
        }
        $scope.consignedBook = openedConsignmentItem.items[0];
      }
    }]);
