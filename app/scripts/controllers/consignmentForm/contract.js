'use strict';

angular.module('consignmentApp')
  .controller('ContractCtrl', ['$scope', 'ContractService',
    function ($scope, ContractService) {

      $scope.contract = ContractService.getContract();

      $scope.stub = function () {

    	};
    }]);