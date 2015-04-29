'use strict';

describe('Controller: FormCtrl', function () {

  // load the controller's module
  beforeEach(module('consignmentApp'));

  var FormCtrl,
      scope, $httpBackend;

  beforeEach(inject(function($injector) {
    // Set up the mock http service responses
    $httpBackend = $injector.get('$httpBackend');

    var mockUserResponse = {
      'error': false,
      'users': [
        {
          'student_id': 0,
          'first_name': 'richard',
          'last_name': 'grayson',
          'email': 'gray@mail.com',
          'phone_number': 2147483647
        },
        {
          'student_id': 1,
          'first_name': 'Clark',
          'last_name': 'Kent',
          'email': 'kent@mail.com',
          'phone_number': 1234541234
        }
      ]
    };

    $httpBackend.when('GET', 'http://timadvance.me/ibu_test/v1/users')
        .respond(mockUserResponse);
  }));

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    FormCtrl = $controller('FormsCtrl', {
      $scope: scope
    });
  }));

  it('should have a list of consignors', function () {
    $httpBackend.flush();
    expect(scope.consignors.length).toBeGreaterThan(0);
  });

  it('goes to the correct consignor details when a consignor is selected', inject(function($location) {
    var testStudentId = 12345678;
    scope.consignor = {studentId: testStudentId};
    scope.viewConsignor();
    expect($location.path()).toEqual('/admin/consignorInfo/' + testStudentId);
  }));
});
