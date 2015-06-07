'use strict';

angular.module('consignmentApp').
  factory('Inventory', ['$resource', 'API_URI', function ($resource, API_URI) {

    var Inventory = $resource(API_URI.inventory);
    return {
      getList: getList
    };

    function getList() {
      return Inventory.get().$promise
        .then(function (response) {
          return response.inventory;
        });
    }
  }])
  .factory('Consignors', ['$resource', 'API_URI', function ($resource, API_URI) {
    return $resource(API_URI.consignors);
  }])
  .factory('Consignor', ['$resource', 'API_URI', function ($resource, API_URI) {
    return $resource(API_URI.consignor);
  }])
  .service('ConsignmentAPI', ['$http', 'API_URI', function($http, API_URI) {
    return {
      'submitForm' : submitForm
    };

    function submitForm(consignment) {
      console.log(consignment);
      return $http.post(API_URI.consignment, consignment);
    }

  }]);
