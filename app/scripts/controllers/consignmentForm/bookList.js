'use strict';

var app = angular.module('consignmentApp');

app.controller('BookFormCtrl', ['$scope', '$modal', '$log', 'BookCartService',
    function ($scope, $modal, $log, BookCartService) {
        $scope.books = BookCartService.getItems();

        $scope.open = function () {
            $scope.modalInstance = $modal.open({
                templateUrl: 'views/consignmentForm/bookModal.html',
                controller: 'BookFormModalCtrl',
                resolve: {
                    consignedBook: function () {
                        return $scope.consignedBook;
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

app.controller('BookFormModalCtrl', ['$scope', '$log', '$modalInstance', 'BookCartService',
    function ($scope, $log, $modalInstance, BookCartService) {

        //TODO: Either complete or remove support multiple courses.
        // Need to instantiate empty array for courses on init.
        var anEmptyBook = {
            courses: []
        };

        $scope.consignedBook = anEmptyBook;

        $scope.addBook = function () {
            $log.info('Consigning book ' + this.consignedBook.isbn + ' for course ' + this.consignedBook.courses[0]);
            BookCartService.addItem(this.consignedBook);
            this.resetForm();
        };

        $scope.cancel = function () {
            $modalInstance.close('cancel');
        };

        $scope.resetForm = function () {
            this.consignedBook = anEmptyBook;
            $scope.consignForm.$setPristine();
        };
    }]);