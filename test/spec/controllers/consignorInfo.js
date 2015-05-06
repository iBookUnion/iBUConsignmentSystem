'use strict';

describe('Controller: ConsignorInfoCtrl', function () {

    // load the controller's module
    beforeEach(module('consignmentApp'));

    var mockUserResponse = {
        'error': false,
        'student_id': 1,
        'first_name': 'Clark',
        'last_name': 'Kent',
        'email': 'kent@mail.com',
        'phone_number': 1234541234
    };

    var ConsignorInfoCtrl,
        scope, httpBackend;

    beforeEach(inject(function ($httpBackend, $rootScope, $controller, API_URI) {
        // Set up the mock http service responses
        httpBackend = $httpBackend;

        httpBackend.when('GET', API_URI.baseURL + '/user/1')
            .respond(mockUserResponse);

        // Initialize the controller and a mock scope
        scope = $rootScope.$new();
        ConsignorInfoCtrl = $controller('ConsignorInfoCtrl', {
            $scope: scope,
            $routeParams: {consignorId: 1}
        });
    }));

    it('retrieves the correct consignor', function () {
        httpBackend.flush();
        expect(scope.contact).toEqual(jasmine.objectContaining(mockUserResponse));
    });
});
