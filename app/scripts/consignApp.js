'use strict';

(function () {
  var app = angular.module('consignmentApp', ['ui.bootstrap', 'ngRoute', 'ngResource', 'parse-angular', 'ngAnimate']);

  app.config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/consignmentForm.html'
      })
      .when('/contract', {
        templateUrl: 'views/contract.html',
        controller: 'ContractCtrl'
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
      .when('/login', {
        templateUrl: 'views/admin/login.html',
        controller: 'AdminLoginCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });

  app.run(function ($rootScope, $location) {
    $rootScope.$on("$routeChangeStart", function () {
      var onAdminPage = $location.url().match(/^\/admin/);
      if (onAdminPage && !Parse.User.current()) {
        $location.path("/login");
      }
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
        templateUrl: 'views/consignmentForm/bookList.html',
        scope: {
          'consignmentForm': '='
        }
      };
    })
    .directive('agreement', function () {
      return {
        restrict: 'E',
        templateUrl: 'views/consignmentForm/agreement.html'
      };
    });
})();