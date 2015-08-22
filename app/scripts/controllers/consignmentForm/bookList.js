'use strict';

var app = angular.module('consignmentApp');

app.controller('BookFormCtrl', ['$scope', '$modal', '$log', 'OPTIONS',
  function ($scope, $modal, $log, OPTIONS) {
    $scope.removeBook = function (book) {
      _.remove($scope.consignment.form.books, function (e) {
        return e === book;
      });
    };

    $scope.states = OPTIONS.bookStates;

    $scope.openBookModal = function (book) {
      $scope.modalInstance = $modal.open({
        templateUrl: 'views/consignmentForm/bookModal.html',
        controller: 'BookFormModalCtrl',
        resolve: {
          existingBook: function () {
            return book;
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

app.controller('BookFormModalCtrl', ['$scope', '$log', '$modalInstance', 'existingBook', 'ConsignmentService', 'Books',
  function ($scope, $log, $modalInstance, existingBook, ConsignmentService, Books) {

    //TODO: Either complete or remove support multiple courses.
    // Need to instantiate empty array for courses on init.
    var anEmptyBook = {
      courses: []
    };

    $scope.alertMessage = '';

    $scope.existingBook = existingBook;

    $scope.consignedBook = existingBook || angular.copy(anEmptyBook);

    $scope.findBookMetadata = function (isbn) {
      Books.get({isbn: isbn}, function (book) {
        $scope.consignedBook = book;
      });
    };

    $scope.submitForm = function () {
      $log.info('Consigning book ' + $scope.consignedBook.isbn + ' for course ' + $scope.consignedBook.courses[0]);
      if (!existingBook) {
        ConsignmentService.form.books.push($scope.consignedBook);
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
      $scope.consignedBook = angular.copy(anEmptyBook);
      $scope.consignForm.$setPristine();
    };

    $scope.addItem = function () {
      //TODO: add new accordion group
    };

    function makeAlert(msg) {
      $scope.alertMessage = msg;
    }
  }]);