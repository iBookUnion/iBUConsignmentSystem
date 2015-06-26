'use strict';

angular.module('consignmentApp')
  .factory('ConsignmentService', ['BookCartService', 'ConsignmentAPI', 'Consignors',
    function (BookCartService, ConsignmentAPI, Consignors) {
    var contactInfo = {};

    return {
      'submitForm': submitForm,
      'retrieveExistingForm': retrieveExistingForm,
      'getContactInfo': getContactInfo,
      'getBookList': getBookList
    };

    function submitForm() {
      var consignmentInfo = buildConsignmentInfo(contactInfo, getBookList());
      ConsignmentAPI.submitForm(consignmentInfo);
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
            'price' : 20
          },
          {
            'isbn': 1987654321321,
            'title': 'long halloween',
            'author': 'loeb',
            'edition': 1,
            'subject': 'TEST',
            'course_number': 101,
            'price' : 21
          }
        ];

      return Consignors.getConsignors(consignmentId)
        .then(function (consignor) {
          // TODO: Get Consignment Object Instead When The API is Working
          contactInfo = consignor;

          // TODO: Get real books associated with the consignment
          BookCartService.addItem(mockBooks);

          return {
            contactInfo : contactInfo,
            books : getBookList()
          };
        });
    }

    function getContactInfo() {
      return contactInfo;
    }

    function getBookList() {
      return BookCartService.getItems();
    }

    function buildConsignmentInfo(contactInfo, books) {
      var consignmentInfo = angular.copy(contactInfo);
      consignmentInfo['books'] = books;
      return consignmentInfo;
    }
  }]);
