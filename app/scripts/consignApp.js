'use strict';

(function () {
    var app = angular.module('consignmentApp', ['ui.bootstrap', 'ngRoute', 'ngResource']);

    app.config(function ($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: '../views/consignmentForm.html'
            })
            .when('/admin', {
                templateUrl: 'views/inventory.html',
                controller: 'InventoryCtrl'
            })
            .when('/admin/forms', {
                templateUrl: 'views/forms.html',
                controller: 'FormsCtrl'
            })
            .when('/admin/consignorInfo/:sno', {
                templateUrl: 'views/consignorInfo.html',
                controller: 'ConsignorInfoCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    });

    app.directive('contactForm', function () {
        return {
            restrict: 'E',
            templateUrl: 'views/consignmentForm/contactForm.html'
        };
    })
        .directive('bookList', function () {
            return {
                restrict: 'E',
                templateUrl: 'views/consignmentForm/bookList.html'
            };
        })
        .directive('agreement', function () {
            return {
                restrict: 'E',
                templateUrl: 'views/consignmentForm/agreement.html'
            };
        });

    app.controller('ConsignmentCtrl', ['$scope', 'BookCartService', function ($scope, BookCartService) {

        $scope.contact = {
            'fname': '',
            'lname': '',
            'sno': '',
            'email': '',
            'phno': '',
            'faculty': '',
            'discovery': ''
        };

        $scope.fname = '';
        console.log($scope.contact.fname);

        $scope.createJson = function () {
            var consignor = {
                'student_id': $scope.contact.sno,
                'first_name': $scope.contact.fname,
                'last_name': $scope.contact.lname,
                'email': $scope.contact.email,
                'phone_number': $scope.contact.phno
            };

            var bookList = BookCartService.getItems();
            console.log(bookList);
            var books = [];
            var consignments = [];

            for (var i = 0; i < bookList.length; i++) {
                var book = {
                    'isbn': bookList[i].isbn,
                    'title': bookList[i].title,
                    'author': bookList[i].author,
                    'edition': 1,
                    'courses': bookList[i].courses
                };

                var consignment = {
                    'isbn': bookList[i].isbn,
                    'student_id': $scope.contact.sno,
                    'price': bookList[i].price,
                    'current_state': '1',
                    'date': 'Now'
                };

                books.push(book);
                consignments.push(consignment);
            }

            var jsonObj = {
                'consignor': consignor,
                'books': books,
                'consignments': consignments
            };

            console.log(JSON.stringify(jsonObj));

            var confirmation = window.open();
            confirmation.document.write(JSON.stringify(jsonObj));
        };

    }]);
})();