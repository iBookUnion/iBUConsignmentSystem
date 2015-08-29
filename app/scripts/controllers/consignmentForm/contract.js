'use strict';

angular.module('consignmentApp')
  .controller('ContractCtrl', ['$scope', 'ContractService',
    function ($scope, ContractService) {
      
      $scope.contract = ContractService.getContract();

      $scope.books = _.flatten(_.map($scope.contract.consignmentItems, function(entry) {
        return entry.items;
      }));
      
      // what is this about??
      $scope.stub = function () {
    	};
    }]);