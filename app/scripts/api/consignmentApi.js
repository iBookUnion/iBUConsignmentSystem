angular.module('consignmentApp')
  .service('ConsignmentApi', ['$http', '$location', 'API_URI', 'ContractService',
    function ($http, $location, API_URI, ContractService) {
      return {
        'submitForm': submitForm,
        'searchConsignments': searchConsignments,
        'getConsignments': getConsignments
      };

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

      function submitForm(form) {
        form = angular.fromJson(angular.toJson(form)); // Strips Angular $ properties
        console.log(form);
        return Parse.Cloud.run('postConsignment', form);
      }
    }]);