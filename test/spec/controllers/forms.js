'use strict';

describe('Controller: FormCtrl', function () {

  // load the controller's module
  beforeEach(module('consignmentApp'));

  var FormCtrl,
    scope, httpBackend;

  beforeEach(inject(function ($httpBackend, $rootScope, $controller, API_URI) {
    // Set up the mock http service responses
    httpBackend = $httpBackend;

    var mockConsignorsResponse = {
      'error': false,
      'consignments': [
        {
          'consignment_number': 0,
          'student_id': 0,
          'first_name': 'richard',
          'last_name': 'grayson',
          'email': 'gray@mail.com',
          'phone_number': '12312341234',
          'isbn': 0,
          'consignment_item': 0,
          'price': '20',
          'current_state': '1',
          'date': '2015-06-15 11:16:14'
        }, {
          'consignment_number': 0,
          'student_id': 1,
          'first_name': 'Clark',
          'last_name': 'Kent',
          'email': 'kent@mail.com',
          'phone_number': '1234541234',
          'isbn': 1,
          'consignment_item': 0,
          'price': '20',
          'current_state': '1',
          'date': '2015-06-15 11:16:14'
        }, {
          'consignment_number': 0,
          'student_id': 2,
          'first_name': 'Bruce',
          'last_name': 'Wayne',
          'email': 'wayne@mail.com',
          'phone_number': '1231231234',
          'isbn': 2,
          'consignment_item': 0,
          'price': '20',
          'current_state': '1',
          'date': '2015-06-15 11:16:14'
        }
      ]
    };

    //httpBackend.when('GET', API_URI.consignors)
    //  .respond(mockUserResponse);

    httpBackend.when('GET', API_URI.consignments)
      .respond(mockConsignorsResponse);

    // Initialize the controller and a mock scope
    scope = $rootScope.$new();
    FormCtrl = $controller('FormsCtrl', {
      $scope: scope
    });
  }));

  it('should have a list of consignors', function () {
    httpBackend.flush();
    expect(scope.consignments.length).toBeGreaterThan(0);
  });

  it('goes to the correct consignor details when a consignor is selected', inject(function ($location) {
    var testStudentId = 12345678;
    scope.viewConsignment({studentId: testStudentId});
    expect($location.path()).toEqual('/admin/consignorInfo/' + testStudentId);
  }));
});
