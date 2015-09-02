'use strict';
var _ = require('cloud/lib/underscore.js');

Parse.Cloud.beforeSave('Book', function (request, response) {
  Parse.Cloud.useMasterKey();
  var promise = Parse.Promise.as();
  var book = request.object;
  if (!book.get('copiesAvailable')) {
    book.set('copiesAvailable', 0);
  }

  if (book.get('title')) {
    book.set('canonicalTitle', book.get('title').toUpperCase());
  }

  if (book.get('courses')) {
    promise = promise
      .then(function () {
        return new Parse.Query('Book').get(book.id);
      })
      .then(function (originalBook) {
        var originalCourses = originalBook.get('courses').match(/[A-Z]{4}\s*\d{3}/g);
        var newCourses = cleanCourseList(book.get('courses')).match(/[A-Z]{4}\d{3}/g);
        var courses = _.union(originalCourses, newCourses).join(',');
        book.set('courses', courses);
        return book;
      });
  }

  promise
    .then(function (book) {
      console.log(book);
      response.success();
    })
    .fail(function (error) {
      response.error(error.message);
    });
});

function cleanCourseList(courses) {
  courses = courses.replace(/\s+/g, '');
  return courses.toUpperCase();
}