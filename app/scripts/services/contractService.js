'use strict';

angular.module('consignmentApp')
  .service('ContractService', [function () {
    // dummy data to be overwritten upon $http.post success
    var contract;

    return {
      'getContract': getContract,
      'setContract': setContract
    };

    function getContract() {
      return contract;
    }

    function setContract(resp) {
      contract = resp;
    }
  }]);