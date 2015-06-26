'use strict';

angular.module('consignmentApp')
  .constant('API_URI', (function () {
    var baseURL = 'http://timadvance.me/ibu_test/v1';
    return {
      'baseURL': baseURL,
      'inventory': baseURL + '/inventory',
      'books': baseURL + '/books/:isbn',
      'consignors': baseURL + '/users',
      'consignor': baseURL + '/user/:consignorId',
      'consignment': baseURL + '/consignments'
    };
  })())
  .constant('OPTIONS', (function () {
    return {
      'bookStates': [
        {
          id: 1,
          name: 'Available'
        },
        {
          id: 2,
          name: 'Not in Store'
        },
        {
          id: 3,
          name: 'Sold'
        },
        {
          id: 4,
          name: 'Closed'
        }
      ],
      'faculties': ['Arts', 'Commerce', 'Music', 'Science', 'Applied Science', 'Forestry', 'Dentistry', 'Human Kinetics']
    };
  })());