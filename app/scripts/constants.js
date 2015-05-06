'use strict';

angular.module('consignmentApp')
    .constant('API_URI', (function () {
        var baseURL = 'http://timadvance.me/ibu_test/v1';
        return {
            'baseURL': baseURL,
            'inventory': baseURL + '/books',
            'consignors': baseURL + '/users',
            'consignor': baseURL + '/user/:consignorId'
        };
    })());