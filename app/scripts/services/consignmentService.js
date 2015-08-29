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
       var defaultForm = getTestData();
        self.form = angular.copy(defaultForm);
        return self;
      }

      function retrieveExistingForm(studentId) {
        return Consignors.getConsignors(studentId)
          .then(function (consignor) {
            self.form = angular.copy(consignor);
            return Consignors.getConsignmentItems(studentId);
          }).then(function (consignedBooks) {
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

      function getTestData() {  
        return {
          "email": "timch326@asdf.ca",
          "faculty": "Arts",
          "firstName": "Hello",
          "lastName": "World",
          "phoneNumber": "1237771234",
          "studentId": "12345678",
          "objectId": "Ay6k25dDFc",
          "createdAt": "2015-08-09T22:30:14.822Z",
          "updatedAt": "2015-08-23T01:18:09.822Z",
          "consignments": [{
            "consignor": {"__type": "Pointer", "className": "Consignor", "objectId": "Ay6k25dDFc"},
            "currentState": "available",
            "items": [{
              "author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567890321",
              "title": "Whatever Happened to...",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"
            }, {"author": "Moore",
              "copiesAvailable": 45,
              "courses": "TEST 101",
              "edition": "Canadian Edition",
              "isbn": "1234567840321",
              "title": "Killing joke",
              "createdAt": "2015-08-09T18:53:46.192Z",
              "updatedAt": "2015-08-23T02:49:08.726Z"}],
            "price": 13,
            "objectId": "doLjOHvWBP",
            "createdAt": "2015-08-11T19:52:28.625Z",
            "updatedAt": "2015-08-11T19:52:28.625Z"}]};}
    }]);
