'use strict';

angular.module('consignmentApp')
  .factory('ConsignmentService', ['ConsignmentApi', 'Consignor',
    function (ConsignmentAPI, Consignor) {
      return {
        'createNewForm': createNewForm,
        'submitForm': submitForm,
        'retrieveExistingForm': retrieveExistingForm
      };

      function submitForm(form) {
        return ConsignmentAPI.submitForm(form);
      }

      function createNewForm() {
        return {
          consignments: []
        };
      }

      function retrieveExistingForm(studentId) {
        var form;
        return Consignor.get(studentId)
          .then(function (consignor) {
            form = angular.copy(consignor);
            return Consignor.getConsignmentItems(studentId);
          })
          .then(function (consignedBooks) {
            form.consignments = consignedBooks;
            return form;
          });
      }
    }]);
