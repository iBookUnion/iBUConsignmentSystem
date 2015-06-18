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
              $scope.contact = consignor;
              $scope.contact.consignmentNo = consignor.studentId;
              $scope.contact.sno = consignor.studentId;
              $scope.contact.fname = consignor.firstName;
              $scope.contact.lname = consignor.lastName;
              $scope.contact.phno = consignor.phoneNumber;
          });

      $scope.faculties = ['Arts', 'Commerce', 'Music', 'Science', 'Applied Science', 'Forestry', 'Dentistry', 'Human Kinetics'];

        $scope.selectSection = function (section) {
            $scope.section = section;
        };

        $scope.saveConsignor = function () {

        };
    });