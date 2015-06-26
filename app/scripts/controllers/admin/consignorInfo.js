'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:ConsignorInfoCtrl
 * @description
 * # ConsignorInfoCtrl
 * Controller of the consignmentApp
 */

angular.module('consignmentApp')
  .controller('ConsignorInfoCtrl', ['$scope', '$routeParams', 'Consignors', 'ConsignmentService', 'OPTIONS',
    function ($scope, $routeParams, Consignors, ConsignmentService, OPTIONS) {

      ConsignmentService.retrieveExistingForm($routeParams.consignorId)
        .then(function (form) {
          $scope.consignment = form.contactInfo;
          $scope.books = form.books;
        });

      // TODO: Use some Auth library to determine if admin access is available
      $scope.isAdmin = true;
      $scope.section = 'contact';
      $scope.states = OPTIONS.bookStates;
      $scope.faculties = OPTIONS.faculties;

      $scope.selectSection = function (section) {
        $scope.section = section;
      };
      $scope.saveConsignor = function () {

      };
    }]);