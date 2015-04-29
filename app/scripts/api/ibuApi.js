'use strict';

angular.module('consignmentApp').
     factory('Inventory', ['$resource', 'API_URI', function($resource, API_URI) {
        return $resource(API_URI.inventory);
    }])
    .factory('Consignors', ['$resource', 'API_URI', function($resource, API_URI) {
        return $resource(API_URI.consignors);
    }]);
