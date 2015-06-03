'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:InventoryCtrl
 * @description
 * # InventoryCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
    .controller('InventoryCtrl', ['$scope', '$location', 'Inventory', function ($scope, $location, Inventory) {

      $scope.selectBook = function(isbn) {
        $location.search('isbn', isbn)
            .path('admin/forms');
      };

      $scope.viewAvailableBookCopies = function() {
        $location.search('isbn', this.book.isbn)
            .path('admin/forms');
      };

      Inventory.getList()
        .then(function (inventory) {
          $scope.books = inventory;
        });

    }]);