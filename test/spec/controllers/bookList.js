'use strict';

// Test Data Used in both controller tests
var fakeModalInstance = {
    result: {
        then: function (confirmCallback, cancelCallback) {
            this.confirmCallback = confirmCallback;
            this.cancelCallback = cancelCallback;
        }
    },
    close: function (consignedBook) {
        this.result.confirmCallback(consignedBook);
    },
    dismiss: function (consignedBook) {
        this.result.cancelCallback(consignedBook);
    }
};
var anEmptyBook = {courses: []};
var newBook = {
    isbn: '1234567890123',
    courses: ['TEST 101'],
    price: 12,
    title: 'Some Book About Testing',
    author: 'The QA Team'
};
var anotherNewBook = {
    isbn: '3210987654321',
    courses: ['TEST 201'],
    price: 35,
    title: 'Some Other Book',
    author: 'Someone'
};

describe('Controller: BookFormCtrl', function () {

    // load the controller's module
    beforeEach(module('consignmentApp'));

    var BookFormCtrl,
        scope, modal, bookCartService;

    beforeEach(inject(function($modal, BookCartService) {
        modal = $modal;
        spyOn(modal, 'open').and.returnValue(fakeModalInstance);
        bookCartService = BookCartService;
        spyOn(bookCartService, 'getItems').and.returnValue([newBook, anotherNewBook]);
    }));

    beforeEach(inject(function($rootScope, $controller) {
        // Initialize the controller and a mock scope
        scope = $rootScope.$new();
        BookFormCtrl = $controller('BookFormCtrl', {
            $scope: scope,
            $modal: modal
        });
    }));

    it('retrieves the list of books in the book cart', function() {
        expect(scope.books).toEqual([newBook, anotherNewBook]);
    });

    it('opens a modal when open() is called', function() {
        scope.open();
        expect(modal.open).toHaveBeenCalled();
    });
});

describe('Controller: BookFormModalCtrl', function () {

    // load the controller's module
    beforeEach(module('consignmentApp'));

    var BookFormModalCtrl,
        scope, mockBookCartService, mockModalInstance;

    beforeEach(inject(function($rootScope, $controller) {
        // Initialize the controller and a mock scope
        scope = $rootScope.$new();
        mockBookCartService = jasmine.createSpyObj('BookCartService', ['addItem']);
        mockModalInstance = jasmine.createSpyObj('modalInstance', ['close', 'dismiss']);

        BookFormModalCtrl = $controller('BookFormModalCtrl', {
            $scope: scope,
            $modalInstance: mockModalInstance,
            BookCartService: mockBookCartService
        });
        scope.consignForm = jasmine.createSpyObj('consignForm', ['$setPristine']);
    }));

    it('has an empty book object at the beginning', function() {
        expect(scope.consignedBook).toEqual(anEmptyBook);
    });

    it('adds a book to the book cart when addBook() is called', function() {
        scope.consignedBook = newBook;
        scope.addBook();
        expect(mockBookCartService.addItem).toHaveBeenCalledWith(newBook);
    });

    it('clears consigned book to be an empty object after addBook() is called', function() {
        scope.consignedBook = newBook;
        scope.addBook();
        expect(scope.consignedBook).toEqual(anEmptyBook);
    });

    it('keeps the modal open after addBook() is called', function() {
        scope.consignedBook = newBook;
        scope.addBook();
        expect(mockModalInstance.dismiss).not.toHaveBeenCalled();
        expect(mockModalInstance.close).not.toHaveBeenCalled();
    });

    it('dismisses the modal when cancel is called', function() {
        scope.cancel();
        expect(mockModalInstance.close).toHaveBeenCalledWith('cancel');
    });

    it('dismisses the modal without adding a new book to the book cart', function() {
        scope.cancel();
        expect(mockBookCartService.addItem).not.toHaveBeenCalled();
    });
});