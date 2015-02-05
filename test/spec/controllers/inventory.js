'use strict';

describe('Controller: InventoryCtrl', function () {

  // load the controller's module
  beforeEach(module('consignmentApp'));

  var MainCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    MainCtrl = $controller('InventoryCtrl', {
      $scope: scope
    });
  }));

  it('should display books available', function () {
    expect(scope.books.length).toBeGreaterThan(0);
  });

  it('search for consignors with a book of the selected isbn', inject(function ($location) {
    var testIsbn = 42;
    scope.book = {isbn : testIsbn};
    scope.viewAvailableBookCopies();
    expect($location.search()['isbn']).toBe(testIsbn);
  }))
});
