'use strict';

angular.module('consignmentApp')
  .controller('BookFormModalCtrl', ['$scope', '$modalInstance',
    'existingConsignmentItem', 'consignmentForm', 'consignor', 'Book', 'OPTIONS',
    function ($scope, $modalInstance,
              existingConsignmentItem, consignmentForm, consignor, Book, OPTIONS) {

      var openedConsignmentItem = angular.copy(existingConsignmentItem) || createNewConsignmentItem();
      if (existingConsignmentItem) {
        openedConsignmentItem.courses = openedConsignmentItem.items[0].courses;
      }

      $scope.consignmentItem = openedConsignmentItem; // bind the consignment item to scope
      bindNewOrExistingBook();

      $scope.alertMessage = '';
      $scope.newBook = [];

      $scope.findBookInfo = function (itemForm, consignmentItem, index) {
        if (itemForm.isbn.$valid) {
          return Book.get(itemForm.isbn.$viewValue)
            .then(_.curryRight(updateBookInfo)(index)(consignmentItem));
        } else {
          enableBookDataEditing(false);
        }
      };

      $scope.submitForm = function () {
        var bundledItems = angular.copy(openedConsignmentItem);
        _.forEach(bundledItems.items, function (book) {
          book.courses = bundledItems.courses;
        });

        var formattedConsignment = {
          'items': bundledItems.items,
          'price': bundledItems.price,
          'currentState': bundledItems.currentState || OPTIONS.bookState.available,
          'consignor': consignor
        };

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
      }

      function updateBookInfo(book, consignmentItem, index) {
        if (book) {
          consignmentItem[index] = book;
          $scope.newBook[index] = false;
        } else {
          // Allow book data fields to be filled
          $scope.newBook[index] = true;
        }
      }

      function enableBookDataEditing(index, option) {
        $scope.newBook[index] = option;
      }
    }]);
