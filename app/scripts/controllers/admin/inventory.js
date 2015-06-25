'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:InventoryCtrl
 * @description
 * # InventoryCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('InventoryCtrl', ['$scope', '$location', 'Inventory',
    function ($scope, $location, Inventory) {

    $scope.viewAvailableBookCopies = function () {
      $location.search('isbn', this.book.isbn)
        .path('admin/forms');
    };

    $scope.searchBooks = function (params) {
      Inventory.getList(params)
        .then(function (inventory) {
          $scope.books = inventory;
        });
    };

    $scope.searchBooks();
  }]);