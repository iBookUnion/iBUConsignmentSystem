'use strict';
var _ = require('cloud/lib/underscore.js');

var states = {
  'available': 1,
  'not in store': 0,
  'sold': 0,
  'consignment complete': 0
};

Parse.Cloud.beforeSave('ConsignmentItem', function (request, response) {
  if (!states.hasOwnProperty(request.object.get('currentState'))) {
    response.error('Invalid current state value: ' + request.object.get('currentState'));
    return;
  }

  updateBookQuantities(request.object)
    .then(function () {
      response.success();
    })
    .fail(response.error);
});

function updateBookQuantities(consignItem) {
  if (!consignItem.existed()) {
    return incrementBookCopies(consignItem.get('items'), 1);
  } else {
    return determineQuantityChange(consignItem)
      .then(function (increment) {
        return incrementBookCopies(consignItem.get('items'), increment);
      });
  }
}

function incrementBookCopies(books, increment) {
  Parse.Cloud.useMasterKey();
  return Parse.Promise.when(_.map(books, function (bookData) {
    // bookData may be instance of Parse.Object or just a plain object
    var bookQuery = new Parse.Query('Book').get(bookData.objectId || bookData.id);
    return bookQuery
      .then(function (book) {
        var copies = book.get('copiesAvailable') + increment;
        book.set('copiesAvailable', copies);
        return book.save(null, {useMasterKey: true});
      });
  }));
}

function determineQuantityChange(consignItem) {
  var currentState = consignItem.get('currentState');
  var query = new Parse.Query('ConsignmentItem');
  return query.get(consignItem.id)
    .then(function (oldConsignItem) {
      var previousState = oldConsignItem.get('currentState');
      return states[currentState] - states[previousState];
    });
}