'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:ConsignorInfoCtrl
 * @description
 * # ConsignorInfoCtrl
 * Controller of the consignmentApp
 */

angular.module('consignmentApp')
    .controller('ConsignorInfoCtrl', function ($scope, $routeParams) {

        $scope.section = 'contact';

        $scope.contact = {
            consignmentNo: 1501,
            fname: 'John',
            lname: 'Chan',
            sno: $routeParams.sno,
            email: 'john@smith.com',
            phno: 5551234567,
            faculty: 'Arts'
        };

        $scope.faculties = ['Arts', 'Commerce', 'Music', 'Science', 'Applied Science', 'Forestry', 'Dentistry', 'Human Kinetics'];

        $scope.selectSection = function (section) {
            $scope.section = section;
        };

        $scope.saveConsignor = function () {

        };
    });