'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:InventoryCtrl
 * @description
 * # InventoryCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('InventoryCtrl', function ($scope, $location, $resource) {

    $scope.selectBook = function(isbn) {
      $location.search('isbn', isbn)
        .path('admin/forms');
    };

    $scope.viewAvailableBookCopies = function() {
      $location.search('isbn', this.book.isbn)
        .path('admin/forms');
    };

      var Books = $resource('http://timadvance.me/ibu_test/v1/books');
      $scope.books = Books.get(function() {
        $scope.books = $scope.books.books;
      });

  });
