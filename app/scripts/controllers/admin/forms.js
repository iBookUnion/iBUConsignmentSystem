'use strict';

/**
 * @ngdoc function
 * @name consignmentApp.controller:FormsCtrl
 * @description
 * # FormsCtrl
 * Controller of the consignmentApp
 */
angular.module('consignmentApp')
    .controller('FormsCtrl', ['$scope', '$routeParams', '$location', 'Consignors', 'Inventory',
        function ($scope, $routeParams, $location, Consignors, Inventory) {

        if ($routeParams.isbn) {
            $scope.isbn = $routeParams.isbn;
            Inventory.get()
        }

        Consignors.get(function (payload) {
            $scope.consignors = payload.users.map(function (apiConsignor) {
                var consignor = {};
                consignor.studentId = apiConsignor.student_id; // jshint ignore:line
                consignor.firstName = apiConsignor.first_name; // jshint ignore:line
                consignor.lastName = apiConsignor.last_name; // jshint ignore:line
                return consignor;
            });
        });


        $scope.viewConsignor = function () {
            $location.url($location.path);  // Clear query parameters
            $location.path('/admin/consignorInfo/' + this.consignor.studentId);
        };

    }]);
