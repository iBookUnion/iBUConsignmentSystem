'use strict';

angular.module('consignmentApp')
  .controller('ContractCtrl', ['$scope', '$location', 'ContractService',
    function ($scope, $location, ContractService) {

      $scope.contract = ContractService.getContract();

      if (!$scope.contract) {
        $location.url('/');
      }
    }]);