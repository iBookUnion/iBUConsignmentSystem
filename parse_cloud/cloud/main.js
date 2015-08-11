var _ = require('underscore');
require('cloud/consignmentItemBeforeSave.js');
require('cloud/bookBeforeSave.js');

Parse.Cloud.define("postConsignment", function (request, response) {
  var consignment = {};
  createConsignorIfNotExists(request.params)
    .then(function (consignor) {
      consignment.consignor = consignor;
      return createConsignmentItems(request.params, consignor);
    })
    .then(
    function (consignmentItems) {
      consignment.consignmentItems = consignmentItems;
      response.success(consignment);
    },
    function (error) {
      response.error(error);
    });
});

function createConsignorIfNotExists(consignorInfo) {
  return getConsignor(consignorInfo.studentId)
    .then(
    function (consignor) {
      if (!consignor.length) {
        consignor = new Parse.Object('Consignor');
        return consignor.save({
          studentId: consignorInfo.studentId,
          firstName: consignorInfo.firstName,
          lastName: consignorInfo.lastName,
          email: consignorInfo.email,
          phoneNumber: consignorInfo.phoneNumber,
          faculty: consignorInfo.faculty
        });
      } else {
        return consignor[0];
      }
    }
  );
}
function getConsignor(studentId) {
  var consignorQuery = new Parse.Query('Consignor');
  return consignorQuery
    .equalTo('studentId', studentId)
    .find();
}

function createConsignmentItems(consignorInfo, consignor) {
  return Parse.Promise.when(_.map(consignorInfo.books, function (bookInfo) {
    return createBookIfNotExists(bookInfo)
      .then(function (book) {
        return createConsignmentEntry(bookInfo, consignor, book);
      });
  }));
}

function createBookIfNotExists(book) {
  return getBook(book.isbn)
    .then(function (result) {
      if (!result.length) {
        var newBook = new Parse.Object('Book');
        return newBook.save({
          isbn: book.isbn.toString(),
          title: book.title,
          author: book.author,
          edition: book.edition,
          courses: book.courses.join(',')
        });
      } else {
        return result[0];
      }
    });
}

function getBook(isbn) {
  var bookQuery = new Parse.Query('Book');
  return bookQuery
    .equalTo('isbn', isbn.toString())
    .find();
}

// TODO: Support Packaged Books
function createConsignmentEntry(itemInfo, consignor, book) {
  var newItem = new Parse.Object('ConsignmentItem');
  return newItem.save({
    consignor: consignor,
    items: [book],
    price: itemInfo.price,
    currentState: 'available'
  });
}