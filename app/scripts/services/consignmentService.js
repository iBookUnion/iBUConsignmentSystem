'use strict';

angular.module('consignmentApp')
  .factory('ConsignmentService', ['ConsignmentApi', 'Consignors',
    function (ConsignmentAPI, Consignors) {
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
        return Consignors.getConsignors(studentId)
          .then(function (consignor) {
            form = angular.copy(consignor);
            return Consignors.getConsignmentItems(studentId);
          })
          .then(function (consignedBooks) {
            form.consignments = consignedBooks;
            return form;
          });
      }
    }]);
