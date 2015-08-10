'use strict';

Parse.Cloud.beforeSave('Book', function(request, response) {
  if (!request.object.get('copiesAvailable')) {
    request.object.set('copiesAvailable', 0);
  }
  response.success();
});