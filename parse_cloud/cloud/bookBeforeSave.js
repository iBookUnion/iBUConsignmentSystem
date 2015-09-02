'use strict';

Parse.Cloud.beforeSave('Book', function(request, response) {
  Parse.Cloud.useMasterKey();
  var book = request.object;
  if (!book.get('copiesAvailable')) {
    book.set('copiesAvailable', 0);
  }
  if (book.get('courses')) {
    book.set('courses', book.get('courses').toUpperCase());
  }
  if (book.get('title')) {
    book.set('canonicalTitle', book.get('title').toUpperCase());
  }
  response.success();
});