'use strict';

angular.module('consignmentApp')
  .factory('Inventory', ['$resource', 'API_URI', function ($resource, API_URI) {

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
  .factory('Consignors', ['$http', 'API_URI', function ($http, API_URI) {
    return {
      getConsignors: getConsignors
    };

    function getConsignors(studentId) {
      var consignorId = studentId ? '/' + studentId : '';
      return $http.get(API_URI.consignors + consignorId)
        .then(function (response) {
          return response.data.users;
        })
        .then(convertToCamelCase)
        .then(function (users) {
          // get the first element of the array if studentId is specified, should update REST API
          var isArray = _.isArray(users);
          return studentId && isArray ? users[0] : users;
        });
    }
  }])
  .factory('ConsignmentAPI', ['$http', 'API_URI', function ($http, API_URI) {
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
      return $http.post(API_URI.consignment, consignment);
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
    console.log(key);
    return _.camelCase(key);
  });
}