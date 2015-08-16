'use strict';

angular.module('consignmentApp')
  .factory('Inventory', ['$resource', 'API_URI',
    function ($resource, API_URI) {
      
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