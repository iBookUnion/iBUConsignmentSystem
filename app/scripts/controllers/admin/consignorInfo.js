'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:ConsignorInfoCtrl
 * @description
 * # ConsignorInfoCtrl
 * Controller of the consignmentApp
 */

angular.module('consignmentApp')
    .controller('ConsignorInfoCtrl', function ($scope, $routeParams, Consignors) {

        $scope.section = 'contact';

        $scope.contact = Consignors.getConsignors($routeParams.consignorId)
          .then(function (consignor) {
              // TODO: Get Consignment Object Instead When The API is Working
              $scope.consignment = consignor;
          });

      $scope.faculties = ['Arts', 'Commerce', 'Music', 'Science', 'Applied Science', 'Forestry', 'Dentistry', 'Human Kinetics'];

        $scope.selectSection = function (section) {
            $scope.section = section;
        };

        $scope.saveConsignor = function () {

        };
    });