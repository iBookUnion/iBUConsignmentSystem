'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:ConsignorInfoCtrl
 * @description
 * # ConsignorInfoCtrl
 * Controller of the consignmentApp
 */

angular.module('consignmentApp')
    .controller('ConsignorInfoCtrl', function ($scope, $routeParams, Consignor) {

        $scope.section = 'contact';

        $scope.contact = Consignor.get({consignorId: $routeParams.consignorId},
            function (response) {
                $scope.contact = response;
                $scope.contact.consignmentNo = $scope.contact.student_id; // jshint ignore:line
                $scope.contact.sno = $scope.contact.student_id; // jshint ignore:line
                $scope.contact.fname = $scope.contact.first_name; // jshint ignore:line
                $scope.contact.lname = $scope.contact.last_name; // jshint ignore:line
                $scope.contact.phno = $scope.contact.phone_number; // jshint ignore:line
            });


        $scope.faculties = ['Arts', 'Commerce', 'Music', 'Science', 'Applied Science', 'Forestry', 'Dentistry', 'Human Kinetics'];

        $scope.selectSection = function (section) {
            $scope.section = section;
        };

        $scope.saveConsignor = function () {

        };
    });