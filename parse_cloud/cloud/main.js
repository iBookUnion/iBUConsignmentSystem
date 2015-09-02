var _ = require('cloud/lib/underscore.js');
require('cloud/consignmentItemBeforeSave.js');
require('cloud/bookBeforeSave.js');
require('cloud/postConsignment.js');

//Parse.Cloud.job('updateUserRoles', function (request, response) {
//  Parse.Cloud.useMasterKey();
//
//  var q = new Parse.Query(Parse.User);
//  q.equalTo('username', 'ibuAdmin')
//    .first().then(addRole)
//    .then(response.success)
//    .fail(response.error);
//
//  function addRole(parseUser) {
//    var query = new Parse.Query(Parse.Role);
//    query.equalTo("name", "admin");
//    return query.first().then(function (object) {
//      object.relation("users").add(parseUser);
//      return object.save();
//    })
//      .fail(function (error) {
//        response.error(error);
//      });
//  }
//
//});

Parse.Cloud.job('migrateBookData', function (request, status) {
  Parse.Cloud.useMasterKey();
  var query = new Parse.Query('Book');
  query.each(function (book) {
      return book.save();
  })
    .then(function () {
      status.success('Migration Complete');
    }, function (error) {
      status.error(error.message);
    });
});

