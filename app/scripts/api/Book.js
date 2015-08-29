'use strict';

angular.module('consignmentApp')
  .factory('Book', [function () {

    var BOOK_KEYS = ['isbn', 'title', 'author', 'edition', 'courses', 'copiesAvailable'];

    var Book = Parse.Object.extend('Book', {
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
        if (params.title) {
          query.contains('title', params.title);
        }
        if (params.subject) {
          query.contains('courses', params.subject.toUpperCase());
        }
      }
      query.greaterThanOrEqualTo('copiesAvailable', 1);
      return query.find();
    }

    _.forEach(BOOK_KEYS, function (keyName) {
      Book.prototype.__defineGetter__(keyName, function () {
        return this.get(keyName);
      });
      Book.prototype.__defineSetter__(keyName, function (aValue) {
        return this.set(keyName, aValue);
      });
    });

    return Book;

  }]);