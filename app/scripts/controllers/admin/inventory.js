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
      
      $scope.isGuest = !Parse.User.current();

      $scope.viewAvailableBookCopies = function () {
        $location.search('isbn', this.book.isbn)
          .path('admin/forms');
      };

      $scope.viewConsignor = function (uniqueId) {
        if (uniqueId){
          console.log(uniqueId);
          var reversedHex = reverseHexId(uniqueId);
          $location.url($location.path);
          $location.path('/admin/consignorInfo/' + reversedHex);
        }
      };

      function reverseHexId(id) {
        var id = String(id);
        return parseInt(id, 16);          
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