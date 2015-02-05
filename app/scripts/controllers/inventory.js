'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:InventoryCtrl
 * @description
 * # InventoryCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
  .controller('InventoryCtrl', function ($scope, $location) {

    $scope.selectBook = function(isbn) {
      $location.search('isbn', isbn)
        .path('admin/forms');
    }

    $scope.viewAvailableBookCopies = function() {
      $location.search('isbn', this.book.isbn)
        .path('admin/forms');
    }

    $scope.books = [
      {
        title: "Some book title",
        author: "John A. Doe",
        edition:"Canadian Edition",
        price: 30,
        status: "3",
        isbn: 42
      },
      {
        title: "Some book title",
        author: "John A. Doe",
        edition:"Canadian Edition",
        price: "30",
        status: "3",
        isbn: 326
      },
      {
        title: "Some book title",
        author: "John A. Doe",
        edition:"Canadian Edition",
        price: "30",
        status: "3",
        isbn: 628
      }
    ];
  });
