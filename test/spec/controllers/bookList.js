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
var book0 = {
    isbn: '1234567890123',
    courses: ['TEST 101'],
    price: 12,
    title: 'Some Book About Testing',
    author: 'The QA Team'
};
var book1 = {
    isbn: '3210987654321',
    courses: ['TEST 201'],
    price: 35,
    title: 'Some Other Book',
    author: 'Someone'
};
var book2 = {
    isbn: 1234567890122,
    title: 'Another book',
    author: 'Quack Duck',
    edition: 12,
    courses: ['ARGH 431', 'SIGH 123'],
    price: 12
};

describe('Controller: BookFormCtrl', function () {

    // load the controller's module
    beforeEach(module('consignmentApp'));

    var BookFormCtrl,
        scope, modal, bookCartService;

    var testBookList = [book0, book1, book2];

    beforeEach(inject(function ($modal, BookCartService) {
        modal = $modal;
        spyOn(modal, 'open').and.returnValue(fakeModalInstance);
        bookCartService = BookCartService;
        testBookList.map(function (book) {
            bookCartService.addItem(book);
        });
        spyOn(bookCartService, 'getItems').and.callThrough();
        spyOn(bookCartService, 'removeItem').and.callThrough();

    }));

    beforeEach(inject(function ($rootScope, $controller) {
        // Initialize the controller and a mock scope
        scope = $rootScope.$new();
        BookFormCtrl = $controller('BookFormCtrl', {
            $scope: scope,
            $modal: modal
        });
    }));

    it('retrieves the list of books in the book cart', function () {
        expect(scope.books.length).toEqual(testBookList.length);
    });

    it('removes an existing book when removeBook() is called', function () {
        scope.removeBook(1);
        expect(bookCartService.removeItem).toHaveBeenCalled();
        expect(scope.books.length).toEqual(testBookList.length - 1);
    });

    it('opens a modal when openBookModal() is called', function () {
        scope.openBookModal();
        expect(modal.open).toHaveBeenCalled();
    });


});

describe('Controller: BookFormModalCtrl opened with no existing book', function () {

    // load the controller's module
    beforeEach(module('consignmentApp'));

    var BookFormModalCtrl,
        scope, mockBookCartService, mockModalInstance, existingBook;
//ll; always beforeEach before unit tests
    beforeEach(inject(function ($rootScope, $controller) {
        // Initialize the controller and a mock scope
        scope = $rootScope.$new();
        mockBookCartService = jasmine.createSpyObj('BookCartService', ['addItem']);
        mockModalInstance = jasmine.createSpyObj('modalInstance', ['close', 'dismiss']); //ll;use $inject if you want to put real thing, and dependecy injection for real modals etc.
        existingBook = {courses: []};

        BookFormModalCtrl = $controller('BookFormModalCtrl', {
            $scope: scope,
            $modalInstance: mockModalInstance,
            BookCartService: mockBookCartService,
            existingBook: undefined
        });
        scope.consignForm = jasmine.createSpyObj('consignForm', ['$setPristine']);
    }));
//ll; these are actual tests 
    it('has an empty book object at the beginning', function () {
        expect(scope.consignedBook).toEqual(anEmptyBook);
    });

    it('adds a book to the book cart when addBook() is called', function () {
        scope.consignedBook = book0;
        scope.addBook();
        expect(mockBookCartService.addItem).toHaveBeenCalledWith(book0);
    });

    it('clears consigned book to be an empty object after addBook() is called', function () {
        scope.consignedBook = book0;
        scope.addBook();
        expect(scope.consignedBook).toEqual(anEmptyBook);
    });

    it('keeps the modal open after addBook() is called', function () {
        scope.consignedBook = book0;
        scope.addBook();
        expect(mockModalInstance.dismiss).not.toHaveBeenCalled();
        expect(mockModalInstance.close).not.toHaveBeenCalled();
    });

    it('dismisses the modal when cancel is called', function () {
        scope.cancel();
        expect(mockModalInstance.close).toHaveBeenCalledWith('cancel');
    });

    it('dismisses the modal without adding a new book to the book cart', function () {
        scope.cancel();
        expect(mockBookCartService.addItem).not.toHaveBeenCalled();
    });
});

describe('Controller: BookFormModalCtrl opened with an existing book', function () {

    // load the controller's module
    beforeEach(module('consignmentApp'));

    var BookFormModalCtrl,
        scope, mockBookCartService, mockModalInstance, existingBook;

    var testBook = {
        isbn: 1234567890123,
        title: 'Some book with a pretty long title to test smaller devices',
        author: 'Tim Cheung',
        edition: 1,
        courses: ['TEST 101'],
        price: 32
    };

    beforeEach(inject(function ($rootScope, $controller) {
        // Initialize the controller and a mock scope
        scope = $rootScope.$new();
        mockBookCartService = jasmine.createSpyObj('BookCartService', ['addItem']);
        mockModalInstance = jasmine.createSpyObj('modalInstance', ['close', 'dismiss']);

        BookFormModalCtrl = $controller('BookFormModalCtrl', {
            $scope: scope,
            $modalInstance: mockModalInstance,
            BookCartService: mockBookCartService,
            existingBook: testBook
        });
        scope.consignForm = jasmine.createSpyObj('consignForm', ['$setPristine']);
    }));

    it('sets consignedBook to be the existingBook when an existing book is passed to the modal', function() {
        expect(scope.consignedBook).toEqual(testBook);
    });

    it('does not try to add an existing book when "Add book" button is clicked', function () {
        scope.addBook();
        expect(mockBookCartService.addItem).not.toHaveBeenCalled();
    });
});