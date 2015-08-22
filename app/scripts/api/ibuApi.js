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
     "first_name": "Marley",
     "last_name": "Davis",
     "student_id": 10000005,
     "email": "marley@test.fds",
     "phone_number": 5553333333,
     "faculty": "Arts",
     "books": [
         {
             "isbn": 105,
             "title": "Clean Code",
             "author": "Bobby Martin",
             "edition": "1st Edition",
             "courses": [
                 {
                     "subject": "CPSC",
                     "course_number": 100
                 }
             ],
             "price": 35,
             "consigned_item": 1,
             "current_state": "available"
         }
     ]
    };

    return {
      'getContract' : getContract,
      'setContract' : setContract
    };

    function getContract() {
     return contract;
    };

    function setContract(resp) {
      contract = resp;
    };
  }])
  .service('ConsignmentAPI', ['$http', '$location', 'API_URI', 'ContractService', 
    function ($http, $location, API_URI, ContractService) {
      return {
      'submitForm': submitForm,
      'searchConsignments': searchConsignments,
      'getConsignments': getConsignments
      };

    function searchConsignments(params) {
      return $http.get(API_URI.consignment,
        {params: params})
        .then(function (response) {
          return response.data.consignments;
        })
        .then(convertToCamelCase);
    }

    function getConsignments(consignmentId) {
      var consignmentParam = consignmentId ? '/' + consignmentId : '';
      return $http.get(API_URI.consignment + consignmentParam)
        .then(function (response) {
          return response.data.consignments;
        })
        .then(convertToCamelCase);
    }

      function submitForm(consignment) {
        console.log(consignment);
        return $http.post(API_URI.consignment, consignment).
        then(function(response) {
          // set contract to be accessible through ContractService
          ContractService.setContract(response);
          $location.path('/contract');
        }, function(response) {
          // if form submission fails, then...(TODO)
          $location.path('/contract');
        });
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