'use strict';

angular.module('consignmentApp')
  .factory('ConsignmentService', ['ConsignmentApi', 'Consignors',
    function (ConsignmentAPI, Consignors) {
      var self = this;
      createNewForm();

      return {
        'form': self.form,
        'createNewForm': createNewForm,
        'submitForm': submitForm,
        'retrieveExistingForm': retrieveExistingForm
      };

      function submitForm(form) {
        return ConsignmentAPI.submitForm(form);
      }

      function createNewForm() {
        var defaultForm = {
          consignments: []
        };
        self.form = angular.copy(defaultForm);
        return self.form;
      }

      function retrieveExistingForm(studentId) {
        return Consignors.getConsignors(studentId)
          .then(function (consignor) {
            self.form = angular.copy(consignor);
            return Consignors.getConsignmentItems(studentId);
          }).then(function(consignedBooks) {
            //var booksList = [];
            //
            //for (var i = 0; i < consignedBooks.length; i++) {
            //  // TODO: Add support for bundled consignment items
            //  var book = consignedBooks[i].items[0];
            //  book.price = consignedBooks[i].price;
            //  book.currentState = consignedBooks[i].currentState;
            //
            //  booksList.push(book);
            //}
            self.form.consignments = consignedBooks;
            return self;
          });
      }
    }]);
