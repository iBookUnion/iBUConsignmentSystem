'use strict';

angular.module('consignmentApp')
  .factory('Inventory', ['$resource', 'API_URI',
    function ($resource, API_URI) {

      var Inventory = $resource(API_URI.inventory);
      return {
        getList: getList
      };
      
    function getList(params) {
      var book = Parse.Object.extend("Book");
      var query = new Parse.Query(book);
      if (params) {
        if (params.title) query.contains("title", params.title);
        if (params.subject) query.contains('courses', params.subject.toUpperCase());
      }
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
        var query = new Parse.Query("Book");
        query.equalTo("isbn", isbn);
        return query.first().then(
          function (book) {
            return book.toJSON();
          });
    }
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
  }])
  .service('ConsignmentAPI', ['$http', '$location', 'API_URI', 'ContractService', 
    function ($http, $location, API_URI, ContractService) {
      return {
      'submitForm': submitForm,
      'searchConsignments': searchConsignments,
      'getConsignments': getConsignments
      };
      
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


  function searchConsignments(params) {
    	var consignments = new Parse.Query("ConsignmentItem");
    	consignments.include("consignor");
    	if (params && params.isbn) {
    		bookForConsignmentQuery(params.isbn).then(
    		  function (book) {
    		    consignments.containedIn("items", book);
    		  })
    	}
    	return consignments.find().then(
    		function (consignments) {
    			return _.map(consignments, function(consignment) {
    				var consignor = consignment.attributes.consignor.toJSON();
    				var consignmentAsJSON = consignment.toJSON();
    				consignmentAsJSON.consignor = consignor;
    					return consignmentAsJSON;
    			})
    		})
    }
    
    function bookForConsignmentQuery(isbn) {
    	var book = new Parse.Query("Book");
    	book.equalTo("isbn", isbn);
    	return book.find().then(
    		function (bookReturned) {
    			return bookReturned;
    	})
    }
    
    function getConsignments(consignmentId) {
      var consignmentParam = consignmentId ? '/' + consignmentId : '';
      return $http.get(API_URI.consignment + consignmentParam)
        .then(function (response) {
          return response.data.consignments;
        })
        .then(convertToCamelCase);
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