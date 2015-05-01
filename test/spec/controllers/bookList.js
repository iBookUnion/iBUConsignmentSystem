'use strict';

describe('Controller: BookFormCtrl', function () {

    // load the controller's module
    beforeEach(module('consignmentApp'));

    var BookFormCtrl,
        scope, modal;

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

    beforeEach(inject(function($modal) {
        modal = $modal;
        spyOn(fakeModalInstance, 'dismiss');
        spyOn(modal, 'open').and.returnValue(fakeModalInstance);
    }));

    beforeEach(inject(function($rootScope, $controller) {
        // Initialize the controller and a mock scope
        scope = $rootScope.$new();
        BookFormCtrl = $controller('BookFormCtrl', {
            $scope: scope,
            $modal: modal
        });
    }));

    it('should open a modal when add book is clicked', function() {
        scope.open();
        expect(modal.open).toHaveBeenCalled();
    });
});
