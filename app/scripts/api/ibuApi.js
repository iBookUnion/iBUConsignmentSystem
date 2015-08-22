'use strict';

angular.module('consignmentApp')
  .factory('Inventory', ['$resource', 'API_URI',
    function ($resource, API_URI) {

      var Inventory = $resource(API_URI.inventory);
      return {
        getList: getList
      };

      function getList(params) {
        return Inventory.get(params).$promise
          .then(function (response) {
            return response.inventory;
          });
      }
    }])
  .factory('Books', ['$resource', 'API_URI', function ($resource, API_URI) {
    return $resource(API_URI.books, {isbn: '@isbn'},
      {
        get: {
          method: 'GET',
          transformResponse: function (response, headers) {
            return convertToCamelCase(JSON.parse(response).books[0]);
          }
        }
      });
  }])
  .factory('Consignor', ['$resource', 'API_URI', function ($resource, API_URI) {
    return $resource(API_URI.consignor);
  }])
  .service('ContractService', [function () {
    // dummy data to be overwritten upon $http.post success
    var contract = {
      'firstName': 'Marley',
      'lastName': 'Davis',
      'studentId': 10000005,
      'email': 'marley@test.fds',
      'phoneNumber': 5553333333,
      'faculty': 'Arts',
      'consignmentItems': [
        {
          'items': [{
            'isbn': 105,
            'title': 'Clean Code',
            'author': 'Bobby Martin',
            'edition': '1st Edition',
            'courses': 'CPSC 100'
          }],
          'price': 35,
          'consigned_item': 1,
          'current_state': 'available'
        }
      ]
    };

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
function convertToCamelCase(object) {
  if (_.isArray(object)) {
    return _.map(object, convertObjectToCamelCase);
  } else {
    return convertObjectToCamelCase(object);
  }
}

function convertObjectToCamelCase(object) {
  return _.mapKeys(object, function (value, key) {
    return _.camelCase(key);
  });
}