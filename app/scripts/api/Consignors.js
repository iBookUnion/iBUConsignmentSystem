'use strict';

angular.module('consignmentApp')
  .factory('Consignors', ['API_URI', function () {
    return {
      'getConsignors': getConsignors,
      'getConsignmentItems': getConsignmentItems
    };

    function getConsignors(studentId) {
      var Consignor = Parse.Object.extend('Consignor');
      var query = new Parse.Query(Consignor);

      if (studentId){
        query.equalTo('studentId', studentId);
      }

      return query.first()
        .then(function (consignor) {
          return consignor.toJSON();
        })
        .fail(function (error) {
          // there was some error retreiving consignor.
          console.log('Consignors.getConsignors: ' + error);
        });
    }

    function getConsignmentItems(studentId) {
      var Consignor = Parse.Object.extend('Consignor');
      var Book = Parse.Object.extend('Book');
      var ConsignmentItem = Parse.Object.extend('ConsignmentItem');

      var query = new Parse.Query(ConsignmentItem);
      var consignorQuery = new Parse.Query(Consignor);

      consignorQuery.equalTo('studentId', studentId);
      query.matchesQuery('consignor', consignorQuery);
      query.include('items');

      return query.find()
        .then(function (consignments) {
          return consignments.map(consignmentItemToJSON);
        })
        .fail(function (error) {
          // there was some error retreiving consigned books.
          console.log('Consignors.getBooks: ' + error);
        });
    }

    // Converts a Parse.Object Consignment Item into a JSON Object
    function consignmentItemToJSON(consignmentItem) {
      var itemsJSON = _.map(consignmentItem.attributes.items, _.method('toJSON'));
      var consignmentItemJSON = consignmentItem.toJSON();
      consignmentItemJSON.items = itemsJSON;
      return consignmentItemJSON;
    }
  }]);
