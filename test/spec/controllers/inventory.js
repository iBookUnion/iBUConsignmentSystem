'use strict';

describe('Controller: InventoryCtrl', function () {

  // load the controller's module
  beforeEach(module('consignmentApp'));

  var MainCtrl,
    scope, $httpBackend;

  beforeEach(inject(function($injector) {
    // Set up the mock http service responses
    $httpBackend = $injector.get('$httpBackend');

    var mockInventoryResponse = {
      'error': false,
      'books': [
        {
          'isbn': 0,
          'title': 'crisis on infinite earths',
          'author': 'wolfman',
          'edition': 0,
          'courses': '12312341234'
        },
        {
          'isbn': 1,
          'title': 'long halloween',
          'author': 'loeb',
          'edition': 1,
          'courses': '1234541234'
        }
      ]
    };

    $httpBackend.when('GET', 'http://timadvance.me/ibu_test/v1/books')
        .respond(mockInventoryResponse);
  }));

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    MainCtrl = $controller('InventoryCtrl', {
      $scope: scope
    });
  }));

  it('should display books available', function () {
    $httpBackend.flush();
    expect(scope.books.length).toBeGreaterThan(0);
  });

  it('search for consignors with a book of the selected isbn', inject(function ($location) {
    var testIsbn = 42;
    scope.book = {isbn : testIsbn};
    scope.viewAvailableBookCopies();
    expect($location.search().isbn).toBe(testIsbn);
  }));
});
