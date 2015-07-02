'use strict';

angular.module('consignmentApp')
  .factory('ConsignmentService', ['ConsignmentAPI', 'Consignors',
    function (ConsignmentAPI, Consignors) {
      var self = this;
      var defaultForm = {
        books: []
      };

      self.form = angular.copy(defaultForm);

      return {
        'form': self.form,
        'createNewForm': createNewForm,
        'submitForm': submitForm,
        'retrieveExistingForm': retrieveExistingForm
      };

      function submitForm() {
        ConsignmentAPI.submitForm(self.form);
      }

      function createNewForm() {
        self.form = angular.copy(defaultForm);
        return self.form;
      }

      function retrieveExistingForm(consignmentId) {
        var mockBooks =
          [
            {
              'isbn': 1234567890321,
              'title': 'crisis on infinite earths',
              'author': 'wolfman',
              'edition': 0,
              'subject': 'TEST',
              'course_number': 100,
              'price': 20
            },
            {
              'isbn': 1987654321321,
              'title': 'long halloween',
              'author': 'loeb',
              'edition': 1,
              'subject': 'TEST',
              'course_number': 101,
              'price': 21
            }
          ];

        return Consignors.getConsignors(consignmentId)
          .then(function (consignor) {
            // TODO: Get Consignment Object Instead When The API is Working
            self.form = angular.copy(consignor);

            // TODO: Get real books associated with the consignment
            self.form.books = mockBooks;
            return self;
          });
      }
    }]);
