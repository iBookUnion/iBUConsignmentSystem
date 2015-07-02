'use strict';

var app = angular.module('consignmentApp');

app.controller('BookFormCtrl', ['$scope', '$modal', '$log', 'ConsignmentService',
  function ($scope, $modal, $log, ConsignmentService) {
    $scope.removeBook = function (book) {
      //BookCartService.removeItem(book);
      _.remove($scope.consignment.books, function (e) {
        return e === book;
      });
    };

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

app.controller('BookFormModalCtrl', ['$scope', '$log', '$modalInstance', 'existingBook', 'ConsignmentService',
  function ($scope, $log, $modalInstance, existingBook, ConsignmentService) {

    //TODO: Either complete or remove support multiple courses.
    // Need to instantiate empty array for courses on init.
    var anEmptyBook = {
      courses: []
    };

    $scope.consignedBook = existingBook || angular.copy(anEmptyBook);

    $scope.addBook = function () {
      $log.info('Consigning book ' + $scope.consignedBook.isbn + ' for course ' + $scope.consignedBook.courses[0]);
      if (!existingBook) {
        ConsignmentService.form.books.push($scope.consignedBook);
        console.log(ConsignmentService.form);
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
  }]);