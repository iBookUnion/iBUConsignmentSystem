'use strict';

angular.module('consignmentApp')
  .factory('ConsignmentService', ['BookCartService', 'ConsignmentAPI', function(BookCartService, ConsignmentAPI) {
    var contactInfo = {};

    return {
      'submitForm': submitForm,
      'getContactInfo': getContactInfo,
      'getBookList': getBookList
    };

    function submitForm() {
      var consignmentInfo = buildConsignmentInfo(contactInfo, getBookList());
      ConsignmentAPI.submitForm(consignmentInfo);
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
