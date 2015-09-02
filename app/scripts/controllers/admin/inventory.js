'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:InventoryCtrl
 * @description
 * # InventoryCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('InventoryCtrl', ['$scope', '$location', 'Book',
    function ($scope, $location, Book) {

      $scope.viewAvailableBookCopies = function () {
        $location.search('isbn', this.book.isbn)
          .path('admin/forms');
      };

      $scope.searchBooks = function (params) {
        $scope.books = [];
        $scope.isLoading = true;
        Book.searchInventory(params)
          .then(function (inventory) {
            $scope.books = inventory;
          })
          .fail(function (error) {
            $scope.errorMessage = 'An Error Occurred: ' + error.message;
          })
          .always(function () {
            $scope.isLoading = false;
          });
      };

      $scope.searchBooks();
    }]);