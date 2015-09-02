'use strict';

angular.module('consignmentApp')
  .factory('Book', ['ParseObject', function (ParseObject) {

    var BOOK_KEYS = ['isbn', 'title', 'author', 'edition', 'courses', 'copiesAvailable'];

    var Book = ParseObject.extend('Book', BOOK_KEYS, {
      // Instance Methods
    }, {
      // Class Methods
      get: get,
      searchInventory: searchInventory
    });

    function get(isbn) {
      var query = new Parse.Query('Book');
      if (isbn) {
        query.equalTo('isbn', isbn);
      }
      return isbn ? query.first() : query.find();
    }

    function searchInventory(params) {
      var query = new Parse.Query('Book');
      if (params) {
        if (params.isbn) {
          query.equalTo('isbn', params.isbn);
        }
        if (params.title) {
          query.contains('canonicalTitle', params.title.toUpperCase());
        }
        if (params.subject) {
          query.contains('courses', params.subject.toUpperCase());
        }
      }
      query.greaterThanOrEqualTo('copiesAvailable', 1);
      return query.find();
    }
    return Book;

  }]);