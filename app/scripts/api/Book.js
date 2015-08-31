'use strict';

angular.module('consignmentApp')
  .factory('Book', ['ParseObject', function (ParseObject) {

    var BOOK_KEYS = ['isbn', 'title', 'author', 'edition', 'courses', 'copiesAvailable'];

    var Book = ParseObject.extend('Book', BOOK_KEYS, {
      // Instance Methods
      initialize: function (attrs, options) {
        var self = this;
        this.fetchByIsbn = function (isbn) {
          isbn = isbn || self.isbn;
          return Book.get(isbn)
            .then(function (book) {
              console.log(self);
              if (book) {
                _.merge(self, book);
              }
              return this;
            });
        };
      }

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

    return Book;

  }]);