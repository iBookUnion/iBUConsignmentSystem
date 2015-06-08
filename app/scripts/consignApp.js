'use strict';

(function () {
  var app = angular.module('consignmentApp', ['ui.bootstrap', 'ngRoute', 'ngResource']);

  app.config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/consignmentForm.html'
      })
      .when('/admin', {
        templateUrl: 'views/inventory.html',
        controller: 'InventoryCtrl'
      })
      .when('/admin/forms', {
        templateUrl: 'views/forms.html',
        controller: 'FormsCtrl'
      })
      .when('/admin/consignorInfo/:consignorId', {
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
    })
    .directive('adminBookList', function () {
      return {
        restrict: 'E',
        templateUrl: 'views/admin/adminBookList.html'
      };
    });
})();