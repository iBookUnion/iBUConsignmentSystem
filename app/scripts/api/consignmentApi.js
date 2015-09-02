angular.module('consignmentApp')
  .service('ConsignmentApi', ['Book',
    function (Book) {
      return {
        'submitForm': submitForm,
        'searchConsignments': searchConsignments,
        'updateConsignment': updateConsignment
      };

      function submitForm(form) {
        form = angular.fromJson(angular.toJson(form)); // Strips Angular $ properties
        return Parse.Cloud.run('postConsignment', form);
      }

      function searchConsignments(params) {
        var consignmentQuery = new Parse.Query('ConsignmentItem')
          .include('consignor');

        var filterQuery = Parse.Promise.as(consignmentQuery);
        if (params && params.isbn) {
          filterQuery = Book.get(params.isbn)
            .then(function (book) {
              return consignmentQuery.containedIn('items', [book]);
            });
        }
        return filterQuery.then(function (query) {
          return query.find().then(consignmentsToJSON);
        });
      }

      /**
       * This updates consignor and consignment items data. Book data are not updated.
       * All books referenced by consignment items are expected to have a Parse objectId
       * and have been already created on Parse.
       * @returns {Parse.Promise}
       */
      function updateConsignment(consignmentForm) {
        var savedConsignment;
        return saveContactInfo(consignmentForm)
          .then(function (consignor) {
            savedConsignment = consignor;
            return saveConsignmentItems(consignmentForm.consignments);
          })
          .then(function (consignmentItems) {
            savedConsignment.consignments = consignmentItems;
            return savedConsignment;
          });
      }

      function saveContactInfo(consignor) {
        var consignorInfo = _.omit(consignor, 'consignments');
        return consignorInfo.save();
      }

      function saveConsignmentItems(consignmentItems) {
        return Parse.Promise.when(_.map(consignmentItems, saveConsignmentItem));

        function saveConsignmentItem(consignmentItem) {
          saveConsignmentBooks(consignmentItem)
            .then(function (bookPointers) {
              var consignmentItemObject = new Parse.Object('ConsignmentItem');
              consignmentItemObject.set('items', bookPointers);
              consignmentItemObject.set('consignor', consignmentItem.consignor);
              consignmentItemObject.set('price', consignmentItem.price);
              consignmentItemObject.set('currentState', consignmentItem.currentState);
              consignmentItemObject.set('objectId', consignmentItem.objectId);
              return consignmentItemObject
                .save()
                .fail(function (error) {
                  console.log(error);
                  return Parse.Promise.error(error);
                });
            });
        }
      }

      function saveConsignmentBooks(consignmentItem) {
        var items = consignmentItem.items;
        var bookPromises = _.map(items, _.method('save'));
        return Parse.Promise.when(bookPromises)
          .then(function () {
            return _.toArray(arguments);
          })
          .then(function (books) {
            return _.map(books, function (book) {
              return Book.createWithoutData(book.id);
            });
          })
          .fail(function () {
            return _.toArray(arguments);
          });
      }

      function consignmentsToJSON(consignments) {
        return _.map(consignments, function (consignment) {
          var consignor = consignment.attributes.consignor.toJSON();
          var consignmentAsJSON = consignment.toJSON();
          consignmentAsJSON.consignor = consignor;
          return consignmentAsJSON;
        });
      }
    }]);