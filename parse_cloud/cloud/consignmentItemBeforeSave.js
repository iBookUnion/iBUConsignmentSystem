'use strict';
var _ = require('underscore');

Parse.Cloud.beforeSave('ConsignmentItem', function (request, response) {
  updateBookQuantities(request.original, request.object)
    .then(function (result) {
      response.success();
    },
    function (error) {
      response.error(error);
    });
});

function updateBookQuantities(oldRecord, newRecord) {
  if (!oldRecord) {
    return incrementBookCopies(newRecord.get('items'), 1);
  } else {
    return determineStatusChange(oldRecord, newRecord);
  }

}
function incrementBookCopies(books, increment) {
  return Parse.Promise.when(_.map(books, function (book) {
    return book.fetch()
      .then(function (result) {
        var copies = result.get('copiesAvailable') + increment;
        result.set('copiesAvailable', copies);
        return book.save();
      });
  }));
}

function determineStatusChange(oldRecord, newRecord) {
  var statusMapping = {
    'available': 1,
    'not in store': 0,
    'sold': 0,
    'consignment complete': 0
  };
  var increment = statusMapping[newRecord.status] - statusMapping[oldRecord.status];
  return incrementBookCopies(newRecord.get('items'), increment);
}