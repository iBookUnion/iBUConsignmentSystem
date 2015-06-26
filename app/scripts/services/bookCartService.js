'use strict';

angular.module('consignmentApp')
  .factory('BookCartService', function () {
    var itemList = [];

    return {
      'getItems': function () {
        return itemList;
      },
      'addItem': function (item) {
        if (_.isArray(item)) {
          _.forEach(item, function(element) {
            itemList.push(element);
          });
        } else {
          itemList.push(item);
        }
      },
      'removeItem': function (item) {
        var index = itemList.indexOf(item);
        itemList.splice(index, 1);
      }
    };
  });
