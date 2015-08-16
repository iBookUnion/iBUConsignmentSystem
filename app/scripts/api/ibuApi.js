'use strict';

angular.module('consignmentApp')
  .factory('Inventory', ['$resource', 'API_URI',
    function ($resource, API_URI) {
<<<<<<< HEAD
      
    return {
      getList: getList
    };

    function getList(params) {
      var book = Parse.Object.extend("Book");
      var query = new Parse.Query(book);
      query.greaterThanOrEqualTo("copiesAvailable", 1);
      return query.find().then(
        function(books) {
          console.log(books);
          return _.map(books, function(book) {
            return book.toJSON();
          })
      })
    }
  }])
  .factory('Books', ['$resource',  function ($resource) {
    
    return{
      getFromParse: getFromParse
    };
    
    function getFromParse(isbn) {
        var Book = Parse.Object.extend("Book");
        var query = new Parse.Query(Book);
        query.equalTo("isbn", isbn);
        return query.first().then(
          function (book) {
            console.log(book.toJSON());
            return book.toJSON();
          }, function(error) {
              // failed to get back the book
        });
    }
=======

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
>>>>>>> 30226a110977fb4d619d42ef81e4f4098efdac25
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
<<<<<<< HEAD
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
      var book = Parse.Object.extend("Book");
      var queryBook = new Parse.Query(book);
      queryBook.equalTo("isbn", params); 
      
      var getBook = function () {
        return queryBook.find().then(
          function (book) {
            return book;
      });
      }
      
      return getBook().then(
          function (book) {
            var consignments = Parse.Object.extend("ConsignmentItem");
            var pointers = _.map(items, function(objectId) {
              var pointer = new Parse.Object("Book");
              pointer.objectId = item_id;
              return pointer;
            })
            var queryConsignments = new Parse.Query(consignments);
            queryConsignments.containedIn("items", pointers);
            
            queryConsignments.find().then(
              function (consignments) {
                  console.log(consignments);
                  return _.map(consignments, function(consignment) {
                      return consignment.toJSON();
                  });
              }); 
      });
    }


    function getConsignments(consignmentId) {
      var consignmentParam = consignmentId ? '/' + consignmentId : '';
      return $http.get(API_URI.consignment + consignmentParam)
        .then(function (response) {
          return response.data.consignments;
        })
        .then(convertToCamelCase);
=======
>>>>>>> 30226a110977fb4d619d42ef81e4f4098efdac25
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