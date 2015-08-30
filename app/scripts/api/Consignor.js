'use strict';

angular.module('consignmentApp')
  .factory('Consignor', ['ParseObject', 'Book', function (ParseObject, Book) {

    var CONSIGNOR_KEYS = ['studentId', 'lastName', 'firstName', 'email', 'phoneNumber', 'faculty'];

    var Consignor = ParseObject.extend('Consignor', CONSIGNOR_KEYS, {
      // Instance Methods
    }, {
      // Class Methods
      get : get,
      getConsignmentItems : getConsignmentItems
    });

    function get(studentId) {
      var query = new Parse.Query('Consignor');
      if (studentId) {
        query.equalTo('studentId', studentId);
      }
      return studentId ? query.first() : query.find();
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
      var consignmentItemJSON = consignmentItem.toJSON();
      consignmentItemJSON.items = consignmentItem.attributes.items;
      return consignmentItemJSON;
    }

    return Consignor;

  }]);