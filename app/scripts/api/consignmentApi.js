angular.module('consignmentApp')
  .service('ConsignmentApi', ['Books',
    function (Books) {
      return {
        'submitForm': submitForm,
        'searchConsignments': searchConsignments,
        'updateConsignment': updateConsignment
      };

      function submitForm(form) {
        form = angular.fromJson(angular.toJson(form)); // Strips Angular $ properties
        console.log(form);
        return Parse.Cloud.run('postConsignment', form);
      }

      function searchConsignments(params) {
        var consignmentQuery = new Parse.Query('ConsignmentItem')
          .include('consignor');

        var filterQuery = Parse.Promise.as(consignmentQuery);
        if (params && params.isbn) {
          filterQuery = Books.getParseObject(params.isbn)
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
        return Parse.Promise.when(saveContactInfo(consignmentForm),
          saveConsignmentItems(consignmentForm.consignments));
      }

      function saveContactInfo(consignor) {
        var consignorObject = new Parse.Object('Consignor');
        var consignorInfo = _.omit(consignor, 'consignments');
        return consignorObject
          .save(sanitizeForParse(consignorInfo))
          .fail(function (error) {
            return Parse.Promise.error(error);
          });
      }

      function saveConsignmentItems(consignmentItems) {
        return Parse.Promise.when(_.map(consignmentItems, saveConsignmentItem));

        function saveConsignmentItem(consignmentItem) {
          var serializedConsignmentItem = serializeConsignmentItem(consignmentItem);
          console.log(serializedConsignmentItem);
          var consignmentItemObject = new Parse.Object('ConsignmentItem');
          return consignmentItemObject
            .save(serializedConsignmentItem)
            .fail(function (error) {
              return Parse.Promise.error(error);
            });
        }
      }

      function serializeConsignmentItem(consignmentItem) {
        var items = consignmentItem.items;
        var consignmentItemCopy = angular.copy(consignmentItem);
        consignmentItemCopy.items = _.map(items, function (item) {
          return Parse.Object.extend('Book').createWithoutData(item.objectId || item.id);
        });
        return consignmentItemCopy;
      }

      function sanitizeForParse(json) {
        return angular.fromJson(angular.toJson(json));
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