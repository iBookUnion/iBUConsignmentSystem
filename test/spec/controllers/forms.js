'use strict';

describe('Controller: FormCtrl', function () {

  // load the controller's module
  beforeEach(module('consignmentApp'));

  var FormCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    FormCtrl = $controller('FormsCtrl', {
      $scope: scope
    });
  }));

  it('should have a list of consignors', function () {
    expect(scope.consignors.length).toBeGreaterThan(0);
  });

  it('goes to consignor details when a consignor is selected', inject(function($location) {
    var testStudentId = 12345678;
    scope.consignor = {studentId: testStudentId};
    scope.viewConsignor()
    expect($location.path()).toEqual('/consignor/' + testStudentId);
  }))
});
