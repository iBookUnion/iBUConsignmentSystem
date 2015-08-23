'use strict';

angular.module('consignmentApp')
  .factory('Books', [function () {

    return {
      getFromParse: get,
      getParseObject: getParseObject
    };

    function get(isbn) {
      return getParseObject(isbn)
        .then(function (results) {
          return isbn ? results.toJSON() : _.map(results, _.method('toJSON'));
        });
    }

    function getParseObject(isbn) {
      var query = new Parse.Query('Book');
      if (isbn) {
        query.equalTo('isbn', isbn);
      }
      return isbn ? query.first() : query.find();
    }
  }]);