'use strict';

(function () {
  var app = angular.module('consignmentApp', ['ui.bootstrap', 'ngRoute', 'ngResource', 'directive.g+signin']);

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
      .when('/admin/login', {
        templateUrl: 'views/admin/login.html',
        controller: 'AdminLoginCtrl'
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
})();