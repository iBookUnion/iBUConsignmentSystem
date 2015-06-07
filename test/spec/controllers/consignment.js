'use strict';

describe('Controller: ConsignmentCtrl', function () {

  // load the controller's module
  beforeEach(module('consignmentApp'));

  var mockContactInfo = {
    'fname': 'Clark',
    'lname': 'Kent',
    'email': 'superman@email.com',
    'phno': 1235554321,
    'sno': 12345678,
    'faculty': 'Arts'
  };

  var mockBookList = [
      {
        'title': 'Hello',
        'isbn': 123567890321,
        'price': 23,
        'author': 'Some authors et. al',
        'courses': ['TEST 101', 'IBUT 321']
      }
    ];

  var expectedInput = {
    'fname': 'Clark',
    'lname': 'Kent',
    'email': 'superman@email.com',
    'phno': 1235554321,
    'sno': 12345678,
    'faculty': 'Arts',
    'books': [
      {
        'title': 'Hello',
        'isbn': 123567890321,
        'price': 23,
        'author': 'Some authors et. al',
        'courses': ['TEST 101', 'IBUT 321']
      }
    ]
  };

  var ConsignmentCtrl,
    scope, httpBackend, consignmentUrl;

  beforeEach(inject(function ($httpBackend, $rootScope, $controller, API_URI, ConsignmentService, BookCartService) {
    // Set up the mock http service responses
    httpBackend = $httpBackend;
    consignmentUrl = API_URI.consignment;

    // Add mock book list to Book Cart Service
    angular.forEach(mockBookList, function(book) {
      BookCartService.addItem(book);
    });

    // Initialize the controller and a mock scope
    scope = $rootScope.$new();
    ConsignmentCtrl = $controller('ConsignmentCtrl', {
      $scope: scope,
      ConsignmentService: ConsignmentService
    });
    angular.extend(scope.consignment, mockContactInfo);
  }));

  it('submits a consignment form correctly', function () {
    httpBackend.expectPOST(consignmentUrl, expectedInput)
      .respond(201, '');
    scope.submitForm();
    httpBackend.flush();

  });
});
