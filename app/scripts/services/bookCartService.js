'use strict';

angular.module('consignmentApp')
    .factory('BookCartService', function() {
       var itemList = [];

        return {
            'getItems' : function() {
                return itemList;
            },
            'addItem' : function(item) {
                itemList.push(item);
            }
        };
    });
