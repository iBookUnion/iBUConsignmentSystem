(function() {
    var BASE_URL = 'http://timadvance.me/ibu_test/v1';
    var Inventory = function($resource) {
        var INVENTORY_URL = BASE_URL + '/books';
        return $resource(INVENTORY_URL);
    };

    var Consignors = function($resource) {
        var CONSIGNOR_URL = BASE_URL + '/users';
        return $resource(CONSIGNOR_URL);
    };

    angular.module('consignmentApp').
         factory('Inventory', Inventory)
        .factory('Consignors', Consignors);
})();
